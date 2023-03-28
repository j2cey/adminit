<?php

namespace App\Models\RetrieveAction;

use Illuminate\Support\Carbon;
use App\Models\ReportFile\ReportFile;
use Illuminate\Support\Facades\Storage;
use App\Models\ReportFile\CollectedReportFile;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Models\ReportTreatments\OperationResult;
use App\Contracts\RetrieveAction\IRetrieveAction;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class ByWildcard Logique de Récupération du ReportFile par wildcard
 * @package App\Models\RetrieveAc
 */
class ByWildcard implements IRetrieveAction
{
    public static function execAction(Filesystem $disk, ReportFile $file, ReportTreatmentStepResult $reporttreatmentstepresult): OperationResult
    {
        $operationresult = OperationResult::createNew("Récupération du ReportFile par Wildcard", 1, $reporttreatmentstepresult, Carbon::now());
        // récupère le chemin du répertoire des CollectedReportFile
        $collectedreportfiles_folder = config('app.collectedreportfiles_folder');

        // variable du nom en local avec nom , temps , extension
        $local_file_name = md5($file->name . '_' . time()) . '.' . $file->extension;

        try {
            //stocker dans la base de données
            $result = Storage::disk('public')->put('/' . $collectedreportfiles_folder . '/' . $local_file_name, $disk->readStream($file->fileRemotePath));
            if ($result) {
                //crée un nouveau fichier
                $collectedreportfile = CollectedReportFile::createNew($file, $file->fileRemotePath, $local_file_name, $disk->size($file->fileRemotePath));

                $operationresult->endWithSuccess("Download success !");
                return $operationresult;
            } else {
                $operationresult->endWithFailure("Error download by wildcard !");
                return $operationresult;
            }
        } catch (\Exception $e) {
            $operationresult->endWithFailure($e->getMessage());
            return $operationresult;
        }
    }
}
