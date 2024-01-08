<?php

namespace App\Models\RetrieveAction;

use App\Enums\QueueDispatchMode;
use App\Services\InnerTreatment;
use App\Enums\CriticalityLevelEnum;
use App\Models\ReportFile\ReportFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Models\ReportFile\CollectedReportFile;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Contracts\RetrieveAction\IRetrieveAction;

/**
 * Class ByName Logique de Récupération du ReportFile par Nom
 * @package App\Models\RetrieveAction
 *
 */
class ByName implements IRetrieveAction
{
    public static function execAction(Filesystem $disk, ReportFile $file, Treatment $treatment, CriticalityLevelEnum $criticalitylevel, int $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment): InnerTreatment
    {
        //if ( ! $disk->exists($file->fileRemotePath) ) {
        //    return $operationresult->endWithFailure("Erreur Connexion / Disponibilité fichier");
        //} else {

        //}

        /*$rename_remotefile_operation = self::renameRemoteFile($disk,$file,$reporttreatmentstep);
        if ($rename_remotefile_operation->isFailed) {
            return $rename_remotefile_operation;
        } else {*/
            return self::downloadRemoteFile($disk, $file, $treatment, $criticalitylevel, $exec_id, $is_last_subtreatment, $can_end_uppertreatment);
        //}
    }

    /*
    private static function renameRemoteFile(Filesystem $disk, ReportFile $file, Treatment $reporttreatmentstep, bool $is_last_subtreatment, bool $can_end_uppertreatment) :TreatmentOperation {
        $operation = $reporttreatmentstep->addTreatmentOperation(TreatmentCodeEnum::DOWNLOADFILE_BYNAME,"Renommage fichier distant",CriticalityLevelEnum::HIGH, QueueDispatchMode::ANYQUEUE)
            ->starting($is_last_subtreatment, $can_end_uppertreatment);

        $new_remote_file_name = $file->remotedir_relative_path . "/" . md5($file->name . '_' . time()) . '.' . $file->extension;

        try {
            $result = $disk->move($file->fileRemotePath, $new_remote_file_name);
            if ($result) {
                $reporttreatmentstep->addToPayload("NewRemoteFileName", $new_remote_file_name);
                $operation->endingWithSuccess("Succes Renommage ! ");
            } else {
                $operation->endingWithFailure("Erreur Renommage !");
            }
            return $operation;
        } catch (\Exception $e) {
            $operation->endingWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode());
            return $operation;
        }
    }
    */

    private static function downloadRemoteFile(Filesystem $disk, ReportFile $file, Treatment $treatment, CriticalityLevelEnum $criticalitylevel, int $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment): InnerTreatment {
        /*
        $operation = $treatment->operationAddOrGet(TreatmentCodeEnum::DOWNLOADFILE_BYNAME, $criticalitylevel, $exec_id, $is_last_subtreatment, $can_end_uppertreatment, false, false, [], null)
            ->starting();
        */
        $innertreatment = new InnerTreatment($treatment, TreatmentCodeEnum::DOWNLOADFILE_BYNAME, $criticalitylevel, $is_last_subtreatment, $can_end_uppertreatment, true, null);
        // récupère le chemin du répertoire des CollectedReportFile
         $collectedreportfiles_folder= config('app.collectedreportfiles_folder');

        try {
            $remote_file_name = $treatment->getPayloadEntry("NewRemoteFileName");
            // \Log::info("Retrieve File ByName - NewRemoteFileName: ".$remote_file_name);
            $remote_file_name = (empty($remote_file_name)) ? $file->fileRemotePath : $remote_file_name;
            // \Log::info("Retrieve File ByName - remote_file_name: ".$remote_file_name);
            // téléchargement et stockage du fichier dans le système de fichier local
            $result = Storage::disk('public')->put('/' . $collectedreportfiles_folder . '/' . $file->localName, $disk->readStream($remote_file_name));
            if ($result) {
                //crée un nouveau fichier collecté (CollectedReportFile)
                $collectedreportfile = CollectedReportFile::createNew($file, $file->fileRemotePath, $file->localName, $disk->size($remote_file_name));
                //$operation->getMainTreatment()->setCollectedReportFile($collectedreportfile);
                $treatment->setCollectedReportFile($collectedreportfile);
                $treatment->getMainTreatment()->setCollectedReportFile($collectedreportfile);

                return $innertreatment->succeed("Download success ! " . "New file collected save as: " . $collectedreportfile->local_file_name);
            } else {
                return $innertreatment->failed("Error download by name !");
            }
        } catch (\Exception $e) {
            return $innertreatment->failed($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode());
        }
    }
}
