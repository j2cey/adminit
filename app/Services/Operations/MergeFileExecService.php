<?php

namespace App\Services\Operations;

use App\Models\SystemLog;
use App\Services\TreatmentStage;
use App\Enums\CriticalityLevelEnum;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Services\Steps\MergeFileStepService;
use App\Enums\Treatments\TreatmentStateEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Traits\ReportTreatment\Operation\TreatmentOperationService;
use App\Contracts\ReportTreatment\Operation\ITreatmentOperationService;

class MergeFileExecService extends MergeFileStepService implements ITreatmentOperationService
{
    use TreatmentOperationService;

    public ?TreatmentStage $stage;

    public Treatment $treatment;
    public int $exec_id;
    public Treatment $importTreatment;
    //public ?CollectedReportFile $collected_report_file;

    public function __construct(Treatment $treatment)
    {
        parent::__construct($treatment);
        $this->treatment = $treatment;
        $this->exec_id = 0;
        self::setCollectedReportFileFromPayload($treatment);
        //$this->collected_report_file = $treatment->service->collectedreportfile;

        $this->initStages();
    }

    public function initStages() {
        $this->stage = new TreatmentStage($this->treatment, $this, TreatmentCodeEnum::DOWNLOADFILE->toArray()['name'], null);
        $this->stage->setFunction("tryMergeRows", CriticalityLevelEnum::HIGH, false, false, "Try merge file rows");

        $this->stage
            ->addNextStageOnSuccess("Try merge file", "tryMergeFile", CriticalityLevelEnum::HIGH, true, true,"Try merge file");
    }

    public function launch(Treatment $treatment): ?Treatment  {
        return self::exec($treatment);
    }

    public function exec(): ?Treatment
    {
        //$treatment->refresh();
        if (!$this->treatment->canBeExecuted) {
            return $this->treatment;
        }

        $this->treatment->starting();

        // try merge Rows
        /*$dynamicrows = $this->treatment->service->collectedreportfile->dynamicrows;

        foreach ($dynamicrows as $row_index => $dynamicrow) {
            // get merged formatted values for each row
            if ( $dynamicrow->isImported ) {
                self::rowFormatAndMergeValues($this->treatment, CriticalityLevelEnum::HIGH, false, true, $dynamicrow, false);
            }
        }

        // try merge File
        if ( $this->treatment->service->collectedreportfile->isImported ) {
            $import_treatment = self::getImportTreatment($this->treatment);

            $format_and_merge_file = self::fileMergeRows( $this->treatment, CriticalityLevelEnum::HIGH, true, true, $this->treatment->service->collectedreportfile, false, false );
            if ( $format_and_merge_file->isSuccess() ) {
                $treatment_payloads = ['collectedReportFileId' => $this->treatment->service->collectedreportfile->id, 'mergeTreatmentId' => $import_treatment->id];
                $this->treatment->launchToGivenUpperStep(TreatmentCodeEnum::NOTIFYFILE, true, true, $treatment_payloads, true);
            }
        } else {
            $this->treatment->endingWithFailure("Import NOT YET DONE");
        }

        return $this->treatment;
        */

        $this->stage->exec();

        return $this->treatment;
    }

    #region Stage Functions
    public function tryMergeRows(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int {
        $dynamicrows = $this->treatment->service->collectedreportfile->dynamicrows;

        foreach ($dynamicrows as $row_index => $dynamicrow) {
            // get merged formatted values for each row
            if ( $dynamicrow->isImported ) {
                self::rowFormatAndMergeValues($this->treatment, CriticalityLevelEnum::HIGH, false, true, $dynamicrow, false);
            }
        }

        return 1;
    }

    public function tryMergeFile(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int {
        if ( $this->treatment->service->collectedreportfile->isImported ) {
            $import_treatment = self::getImportTreatment($this->treatment);

            $format_and_merge_file = self::fileMergeRows( $this->treatment, CriticalityLevelEnum::HIGH, true, true, $this->treatment->service->collectedreportfile, false, false );
            if ( $format_and_merge_file->isSuccess() ) {
                $treatment_payloads = ['collectedReportFileId' => $this->treatment->service->collectedreportfile->id, 'mergeTreatmentId' => $import_treatment->id];
                $this->treatment->launchUpperStep(TreatmentCodeEnum::NOTIFYFILE, $treatment_payloads, true, null);
            }
            return 1;
        } else {
            $this->treatment->endingWithFailure("Import NOT YET DONE");
            return -1;
        }
    }
    #endregion

    public function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {
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
