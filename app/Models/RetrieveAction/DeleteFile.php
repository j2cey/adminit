<?php

namespace App\Models\RetrieveAction;

use App\Enums\CriticalityLevelEnum;
use App\Models\ReportFile\ReportFile;
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
    public static function execAction(Filesystem $disk, ReportFile $file,ReportTreatmentStepResult $reporttreatmentstepresult, CriticalityLevelEnum $criticalitylevelenum): OperationResult
    {
        $operationresult = $reporttreatmentstepresult->addOperationResult("Suppression du Fichier Remote", CriticalityLevelEnum::HIGH)
            ->setCriticalityLevel($criticalitylevelenum);

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
