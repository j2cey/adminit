<?php

namespace App\Models\RetrieveAction;

use App\Models\Reports\Report;
use Illuminate\Support\Carbon;
use App\Models\ReportFile\ReportFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Models\ReportTreatments\OperationResult;
use App\Contracts\RetrieveAction\IRetrieveAction;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class ByName Logique de Suppression du ReportFile
 * @package App\Models\RetrieveAction
 *
 */
class DeleteFile implements IRetrieveAction
{
    public static function execAction(Filesystem $disk, ReportFile $file,ReportTreatmentStepResult $reporttreatmentstepresult): OperationResult
    {
        $operationresult = OperationResult::createNew("Suppression du ReportFile",1,$reporttreatmentstepresult, Carbon::now());

        try{
            $result = $disk->delete($file->fileRemotePath);

            if($result) {
                $operationresult->endWithSuccess("Delete success !");
                return $operationresult;
            } else{
                $operationresult->endWithFailure("Error delete !");
                return $operationresult;
            }
        }
        catch (\Exception $e){
            $operationresult->endWithFailure($e->getMessage());
            return $operationresult;}
    }

}
