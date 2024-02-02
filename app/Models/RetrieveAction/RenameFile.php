<?php

namespace App\Models\RetrieveAction;


use App\Enums\CriticalityLevelEnum;
use App\Models\Treatments\Treatment;
use App\Models\ReportFile\ReportFile;
use App\Services\Treatments\InnerTreatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Contracts\RetrieveAction\IRetrieveAction;

class RenameFile implements IRetrieveAction
{
    /**
     * @param Filesystem $disk
     * @param ReportFile $file
     * @param Treatment $treatment
     * @param CriticalityLevelEnum $criticalitylevelenum
     * @param bool $is_last_subtreatment
     * @param bool $can_end_uppertreatment
     * @return InnerTreatment
     */
    public static function execAction(Filesystem $disk, ReportFile $file, Treatment $treatment, CriticalityLevelEnum $criticalitylevelenum, bool $is_last_subtreatment = false, bool $can_end_uppertreatment = false): InnerTreatment
    {
        $operation = $treatment->operationAddOrGet(TreatmentCodeEnum::DOWNLOADFILE_RENAME, CriticalityLevelEnum::HIGH, $is_last_subtreatment, $can_end_uppertreatment, false, [], null)
            ->starting();

        // variable du nom en local avec nom , temps , extension
        //$local_file_name = md5($file->name . '_' . time()) . '.' . $file->extension;

        try{
            $remote_file_name = $treatment->getPayloadEntry("NewRemoteFileName");
            $remote_file_name = (empty($remote_file_name)) ? $file->fileRemotePath : $remote_file_name;

            $result = $disk->move($remote_file_name, $file->localName);

            if($result) {
                return $operation->endingWithSuccess("Rename success !");
            } else{
                return $operation->endingWithFailure("Error rename !");
            }
        }
        catch (\Exception $e){
            return $operation->endingWithFailure($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode());
        }
    }

}
