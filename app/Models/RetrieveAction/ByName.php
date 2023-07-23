<?php

namespace App\Models\RetrieveAction;

use App\Enums\CriticalityLevelEnum;
use App\Models\ReportFile\ReportFile;
use Illuminate\Support\Facades\Storage;
use App\Models\ReportFile\CollectedReportFile;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Models\ReportTreatments\OperationResult;
use App\Contracts\RetrieveAction\IRetrieveAction;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class ByName Logique de Récupération du ReportFile par Nom
 * @package App\Models\RetrieveAction
 *
 */
class ByName implements IRetrieveAction
{
    public static function execAction(Filesystem $disk, ReportFile $file, ReportTreatmentStepResult $reporttreatmentstepresult, CriticalityLevelEnum $criticalitylevelenum, bool $is_last_operation = false): OperationResult
    {
        $operationresult = $reporttreatmentstepresult->addOperationResult("Récupération du ReportFile par Nom",CriticalityLevelEnum::HIGH, $is_last_operation)
            ->startOperation();

        //if ( ! $disk->exists($file->fileRemotePath) ) {
        //    return $operationresult->endWithFailure("Erreur Connexion / Disponibilité fichier");
        //} else {

            // récupère le chemin du répertoire des CollectedReportFile
            $collectedreportfiles_folder = config('app.collectedreportfiles_folder');

            // variable du nom en local avec nom , temps , extension
            $local_file_name = md5($file->name . '_' . time()) . '.' . $file->extension;

            try {
                //stocker dans la base de données
                $result = Storage::disk('public')->put('/' . $collectedreportfiles_folder . '/' . $local_file_name, $disk->readStream($file->fileRemotePath));
                if ($result) {
                    //crée un nouveau fichier collecté (CollectedReportFile)
                    $collectedreportfile = CollectedReportFile::createNew($file, $file->fileRemotePath, $local_file_name, $disk->size($file->fileRemotePath));

                    $operationresult->endWithSuccess("Download success ! " . "New file collected save as: " . $collectedreportfile->local_file_name);
                } else {
                    $operationresult->endWithFailure("Error download by name !");
                }
                return $operationresult;
            } catch (\Exception $e) {
                $operationresult->endWithFailure($e->getMessage());
                return $operationresult;
            }
        //}
    }
}
