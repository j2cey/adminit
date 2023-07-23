<?php

namespace App\Models\RetrieveAction;

use Illuminate\Support\Carbon;
use App\Enums\CriticalityLevelEnum;
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
    public static function execAction(Filesystem $disk, ReportFile $file, ReportTreatmentStepResult $reporttreatmentstepresult, CriticalityLevelEnum $criticalitylevelenum, bool $is_last_operation = false): OperationResult
    {
        $operationresult = $reporttreatmentstepresult->addOperationResult("Renommage du ReportFile", CriticalityLevelEnum::HIGH, $is_last_operation)
            ->startOperation();

        // variable du nom en local avec nom , temps , extension
        $local_file_name = md5($file->name . '_' . time()) . '.' . $file->extension;

        try{
            $result = $disk->move($file->fileRemotePath, $local_file_name);

            if($result) {
                return $operationresult->endWithSuccess("Rename success !");
            } else{
                return $operationresult->endWithFailure("Error rename !");
            }
        }
        catch (\Exception $e){
            return $operationresult->endWithFailure($e->getMessage());
        }
    }

}
