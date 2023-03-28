<?php

namespace App\Models\RetrieveAction;

use Illuminate\Support\Carbon;
use App\Models\ReportFile\ReportFile;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Models\ReportTreatments\OperationResult;
use App\Contracts\RetrieveAction\IRetrieveAction;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

class RenameFile implements IRetrieveAction
{
    /**
     * @param Filesystem $disk
     * @param ReportFile $file
     * @param ReportTreatmentStepResult $reporttreatmentstepresult
     * @return OperationResult
     */
    public static function execAction(Filesystem $disk, ReportFile $file, ReportTreatmentStepResult $reporttreatmentstepresult): OperationResult
    {
        $operationresult = OperationResult::createNew("Renommage du ReportFile",1,$reporttreatmentstepresult, Carbon::now());

        // variable du nom en local avec nom , temps , extension
        $local_file_name = md5($file->name . '_' . time()) . '.' . $file->extension;

        try{
            $result = $disk->move($file->fileRemotePath,$local_file_name);

            if($result) {
                $operationresult->endWithSuccess("Rename success !");
                return $operationresult;
            } else{
                $operationresult->endWithFailure("Error rename !");
                return $operationresult;
            }
        }
        catch (\Exception $e){
            $operationresult->endWithFailure($e->getMessage());
            return $operationresult;}

    }

}
