<?php

namespace App\Models\RetrieveAction;

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
 * Class ByWildcard Logique de Récupération du ReportFile par wildcard
 * @package App\Models\RetrieveAc
 */
class ByWildcard implements IRetrieveAction
{
    public static function execAction(Filesystem $disk, ReportFile $file, Treatment $treatment, CriticalityLevelEnum $criticalitylevel, int $exec_id, bool $is_last_subtreatment = false, bool $can_end_uppertreatment = false): InnerTreatment
    {
        /*
        $operation = $treatment->operationAddOrGet("Récupération du ReportFile par Wildcard", CriticalityLevelEnum::HIGH, $exec_id, $is_last_subtreatment, $can_end_uppertreatment, true, false, [], null)
            ->starting();
        */
        $innertreatment = new InnerTreatment($treatment, TreatmentCodeEnum::DOWNLOADFILE_WILDCARD, $criticalitylevel, $is_last_subtreatment, $can_end_uppertreatment, true, null);

        // récupère le chemin du répertoire des CollectedReportFile
        $collectedreportfiles_folder = config('app.collectedreportfiles_folder');

        // variable du nom en local avec nom , temps , extension
        //$local_file_name = md5($file->name . '_' . time()) . '.' . $file->extension;

        try {
            //stocker dans la base de données
            $result = Storage::disk('public')->put('/' . $collectedreportfiles_folder . '/' . $file->localName, $disk->readStream($file->fileRemotePath));
            if ($result) {
                //crée un nouveau fichier
                $collectedreportfile = CollectedReportFile::createNew($file, $file->fileRemotePath, $file->localName, $disk->size($file->fileRemotePath));
                //$operation->getMainTreatment()->setCollectedReportFile($collectedreportfile);
                $treatment->getMainTreatment()->setCollectedReportFile($collectedreportfile);

                return $innertreatment->succeed("Download success !");
            } else {
                return $innertreatment->failed("Error download by wildcard !");
            }
        } catch (\Exception $e) {
            return $innertreatment->failed($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode());
        }
    }
}
