<?php

namespace App\Services\Operations;

use App\Models\SystemLog;
use App\Enums\CriticalityLevelEnum;
use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Services\Steps\MergeFileStepService;
use App\Enums\Treatments\TreatmentStateEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Traits\ReportTreatment\Operation\TreatmentOperationService;
use App\Contracts\ReportTreatment\Operation\ITreatmentOperationService;

class MergeFileExecService extends MergeFileStepService implements ITreatmentOperationService
{
    use TreatmentOperationService;

    public static function launch(Treatment $treatment): ?Treatment  {
        return self::exec($treatment);
    }

    public static function exec(Treatment $treatment): ?Treatment
    {
        $treatment->refresh();
        if (!$treatment->canBeExecuted) {
            return $treatment;
        }

        $treatment->starting();

        self::setCollectedReportFileFromPayload($treatment);

        // try merge Rows
        $dynamicrows = $treatment->service->collectedreportfile->dynamicrows;

        foreach ($dynamicrows as $row_index => $dynamicrow) {
            // get merged formatted values for each row
            if ( $dynamicrow->isImported ) {
                self::rowFormatAndMergeValues($treatment, CriticalityLevelEnum::HIGH, false, true, $dynamicrow, false);
            }
        }

        // try merge File
        if ( $treatment->service->collectedreportfile->isImported ) {
            $import_treatment = self::getImportTreatment($treatment);

            $format_and_merge_file = self::fileMergeRows( $treatment, CriticalityLevelEnum::HIGH, true, true, $treatment->service->collectedreportfile, false, false );
            if ( $format_and_merge_file->isSuccess() ) {
                $treatment_payloads = ['collectedReportFileId' => $treatment->service->collectedreportfile->id, 'mergeTreatmentId' => $import_treatment->id];
                $treatment->launchToGivenUpperStep(TreatmentCodeEnum::NOTIFYFILE, true, true, $treatment_payloads, true);
            }
        } else {
            $treatment->endingWithFailure("Import NOT YET DONE");
        }

        return $treatment;
    }

    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {
        SystemLog::infoTreatments("MergeFileExecService - postEnding. isFailed: " . ($treatment->isFailed ? "true" : "false") . ", state: " . $treatment->state->value, Treatment::$TREATMENT_ENDING_LOG_INFO_PART);
        if ( $treatment->isFailed && $treatment->state === TreatmentStateEnum::ALLTRIED ) {
            $max_retries = config('Settings.treatment.merge_file.max_retries');
            SystemLog::infoTreatments("MergeFileExecService - postEnding. max_retries: " . $max_retries, Treatment::$TREATMENT_ENDING_LOG_INFO_PART);
            if ( $treatment->attempts < $max_retries ) {
                $treatment->resetRetrySession();
                $treatment->setState( TreatmentStateEnum::WAITING );
            }
        }
    }
}
