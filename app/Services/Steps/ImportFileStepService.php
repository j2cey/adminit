<?php

namespace App\Services\Steps;

use App\Enums\QueueEnum;
use App\Services\InnerTreatment;
use App\Enums\CriticalityLevelEnum;
use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Models\ReportFile\CollectedReportFile;
use App\Traits\ReportTreatment\Step\TreatmentStepService;
use App\Contracts\ReportTreatment\Step\ITreatmentStepService;

class ImportFileStepService implements ITreatmentStepService
{
    use TreatmentStepService;

    public static function getQueueCode(): QueueEnum
    {
        return QueueEnum::IMPORTFILE;
    }
    public static function launchExecOpertion(Treatment $treatment, int|null $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $nexttreatment_payloads, bool $dispatch_on_creation): ?Treatment {
        return $treatment->launchNewSubOperation(TreatmentCodeEnum::IMPORTFILE_EXEC, CriticalityLevelEnum::HIGH, $exec_id ?? 1, $is_last_subtreatment, $can_end_uppertreatment, $nexttreatment_payloads, $dispatch_on_creation, false, false, null);
    }

    public static function launch(Treatment $treatment): ?Treatment {
        return self::launchExecOpertion($treatment, null, true, true, [], true);
    }

    public static function exec(Treatment $treatment): ?Treatment {
        if ( $treatment->subtreatments()->waiting()->count() > 0 ) {
            $treatment->firstWaitingSubTreatment()->service->dispatch($treatment->reportfile);

            return $treatment;
        }
        //ConsoleLog::info("DownloadFileStepService executed - Nothing to do");
        return $treatment;
    }

    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }

    #region Private Functions

    /**
     * Erase all imported data
     * @param CollectedReportFile $collectedreportfile
     * @param Treatment $treatment
     * @param CriticalityLevelEnum $criticalitylevel
     * @param int $exec_id
     * @param bool $reset_imported
     * @param bool $is_last_subtreatment
     * @param bool $can_end_uppertreatment
     * @return InnerTreatment
     */
    public static function deleteImportedData(CollectedReportFile $collectedreportfile, Treatment $treatment, CriticalityLevelEnum $criticalitylevel, int $exec_id, bool $reset_imported, bool $is_last_subtreatment = false, bool $can_end_uppertreatment = false): InnerTreatment
    {
        $innertreatment = new InnerTreatment($treatment, TreatmentCodeEnum::IMPORT_START, $criticalitylevel, $is_last_subtreatment, $can_end_uppertreatment, true, null);
        if ( ! $reset_imported ) {
            return $innertreatment->succeed("Not to reset imported data !");
        }

        /*$operation = $treatment->operationAddOrGet(TreatmentCodeEnum::IMPORT_DEL, CriticalityLevelEnum::HIGH, $exec_id, $all_sub_treatments_launched, $can_end_upper_treatment, false, false, [], null)
            ->starting();*/

        try {
            $collectedreportfile->deleteRows();
            $collectedreportfile->lines_values = "[]";

            return $innertreatment->succeed( null );
        } catch (\Exception $e) {
            return $innertreatment->failed($e->getMessage());
        }
    }

    public static function isImportFileDone(Treatment $treatment): bool {
        return $treatment->service->collectedreportfile->isImported;
    }
    #endregion
}
