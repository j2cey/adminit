<?php

namespace App\Models\RetrieveAction;

use App\Enums\CriticalityLevelEnum;
use App\Models\Treatments\Treatment;
use App\Models\ReportFile\ReportFile;
use App\Services\Treatments\InnerTreatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Contracts\RetrieveAction\IRetrieveAction;

/**
 * Class ByName Logique de Suppression du ReportFile
 * @package App\Models\RetrieveAction
 *
 */
class DeleteFile implements IRetrieveAction
{
    public static function execAction(Filesystem $disk, ReportFile $file, Treatment $treatment, CriticalityLevelEnum $criticalitylevel, int $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment = false): InnerTreatment
    {
        /*
        $operation = $treatment->operationAddOrGet(TreatmentCodeEnum::DOWNLOADFILE_DELETE, $criticalitylevel, $exec_id, $is_last_subtreatment, $can_end_uppertreatment, false, false, [], null)
            ->starting();
        */
        $innertreatment = new InnerTreatment($treatment, TreatmentCodeEnum::DOWNLOADFILE_DELETE, $criticalitylevel, $is_last_subtreatment, $can_end_uppertreatment, true, null);

        try{
            $remote_file_name = $treatment->getPayloadEntry("NewRemoteFileName");
            // \Log::info("DeleteFile - NewRemoteFileName: ".$remote_file_name);
            $remote_file_name = (empty($remote_file_name)) ? $file->fileRemotePath : $remote_file_name;
            // \Log::info("DeleteFile - remote_file_name: ".$remote_file_name);

            $result = $disk->delete($remote_file_name);

            if($result) {
                return $innertreatment->succeed("Delete success !");
            } else {
                return $innertreatment->failed("Error delete ! " . $result);
            }
        }
        catch (\Exception $e) {
            return $innertreatment->failed($e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode());
        }
    }

}
