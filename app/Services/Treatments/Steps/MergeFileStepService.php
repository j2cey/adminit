<?php

namespace App\Services\Treatments\Steps;

use App\Enums\QueueEnum;
use App\Enums\CriticalityLevelEnum;
use App\Models\Treatments\Treatment;
use App\Models\DynamicValue\DynamicRow;
use App\Services\Treatments\InnerTreatment;
use App\Services\Treatments\TreatmentStage;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Models\ReportFile\CollectedReportFile;
use App\Traits\ReportTreatment\Step\TreatmentStepService;
use App\Contracts\ReportTreatment\Step\ITreatmentStepService;

class MergeFileStepService implements ITreatmentStepService
{
    use TreatmentStepService;

    public ?TreatmentStage $stage;

    public Treatment $treatment;
    public int $exec_id;
    public Treatment $importTreatment;

    public function __construct(Treatment $treatment)
    {
        $this->treatment = $treatment;
        $this->exec_id = 0;
        self::setCollectedReportFileFromPayload($treatment);

        $this->initStages();
    }

    public function initStages() {
        $this->stage = new TreatmentStage($this->treatment, $this, TreatmentCodeEnum::DOWNLOADFILE->toArray()['name'], null, true);
        $this->stage->setFunction("tryMergeRows", CriticalityLevelEnum::HIGH, false, false, null, "Try merge file rows");

        $this->stage
            ->addNextStageOnSuccess("Try merge file", true, "tryMergeFile", CriticalityLevelEnum::HIGH, true, true, null,"Try merge file");
    }

    public static function getQueueCode(): QueueEnum
    {
        return QueueEnum::MERGEFILE;
    }

    /*public function launchExecOpertion(Treatment $treatment, int|null $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $nexttreatment_payloads, bool $dispatch_on_creation): ?Treatment {
        return $treatment->launchNewSubOperation(TreatmentCodeEnum::MERGEFILE_EXEC, CriticalityLevelEnum::HIGH, $exec_id ?? 1, true, true, $nexttreatment_payloads, $dispatch_on_creation, false, false, null);
    }*/

    /*public function launch(Treatment $treatment): ?Treatment {
        return self::launchExecOpertion($treatment, null, true, true, [], true);
    }*/

    public function exec(): ?Treatment {
        if (!$this->treatment->canBeExecuted) {
            return $this->treatment;
        }

        $this->treatment->starting();
        $this->stage->exec($this->treatment->break_point);

        return $this->treatment;
    }

    public function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }

    public function getNextOnSuccess(): ?TreatmentCodeEnum {
        return TreatmentCodeEnum::NOTIFYFILE;
    }

    public function launchNextOnSuccess(array $payloads) {
        $this->treatment->reloadCollectedreportfile();
        $payloads = self::addCollectedReportFileToPayload($payloads, $this->treatment->collectedreportfile);
        $this->treatment->launchUpperStep($this->getNextOnSuccess() , true, true, $payloads, true, null);
    }

    public function getNextOnFailure(): ?TreatmentCodeEnum {
        return null;
    }

    public function launchNextOnFailure(array $payloads) {

    }

    #region Stage Functions
    public function launchMergeFileExec(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int {
        $treatment_payloads = ['collectedReportFileId' => $this->treatment->getPayloadEntry("collectedReportFileId"), 'importTreatmentId' => $this->treatment->getPayloadEntry("importTreatmentId")];
        $import_operation = $this->treatment->operationAddOrGet(TreatmentCodeEnum::MERGEFILE_EXEC, $criticality_level, ++$this->exec_id, $is_last_subtreatment, $can_end_uppertreatment, false, false, false, $treatment_payloads, null);
        $import_operation->service->setReportFile($this->treatment->service->reportfile);
        $import_operation->service->setCollectedReportFile($this->treatment->service->collectedreportfile);

        return 1;
    }

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
        $this->treatment->service->collectedreportfile->reloadFormattingResult();
        if ( $this->treatment->service->collectedreportfile->isFormatted ) {
            //$import_treatment = self::getImportTreatment($this->treatment);

            $format_and_merge_file = self::fileMergeRows( $this->treatment, CriticalityLevelEnum::HIGH, true, true, $this->treatment->service->collectedreportfile, false, false );
            if ( $format_and_merge_file->isSuccess() ) {
                $this->launchNextOnSuccess(['mergeTreatmentId' => $this->treatment->id]);
            }
            return 1;
        } else {
            $this->treatment->endingWithFailure("Import NOT YET DONE");
            return -1;
        }
    }
    #endregion

    public static function getImportTreatment(Treatment $treatment): ?Treatment
    {
        return Treatment::getById( (int) $treatment->getPayloadEntry("importTreatmentId") );
    }

    public static function fileMergeRows(Treatment $treatment, CriticalityLevelEnum $criticalitylevel, bool $is_last_subtreatment, bool $can_end_uppertreatment, CollectedReportFile $collectedreportfile, bool $format_and_merge_rows, bool $format_values): InnerTreatment {
        $innertreatment = new InnerTreatment($treatment, TreatmentCodeEnum::MERGEFORMATTEDFILE, $criticalitylevel, $is_last_subtreatment, $can_end_uppertreatment, false, "File: " . $collectedreportfile->id);

        try {
            // reset rawvalues from formatted values
            $collectedreportfile->resetRawValues();
            $collectedreportfile->insertHeadersRow($collectedreportfile->getHeaders(), $collectedreportfile->reportfile->report->fileheader->formatrules);

            // get all dynamic rows attached to this file
            $dynamicrows = $collectedreportfile->dynamicrows;

            $last_row = null;

            foreach ($dynamicrows as $row_index => $dynamicrow) {
                // get merged formatted values for each row
                if ( $format_and_merge_rows ) {
                    self::rowFormatAndMergeValues($treatment, CriticalityLevelEnum::HIGH, false, false, $dynamicrow, $format_values);
                }

                $can_merge_this_row = false;

                if ( $collectedreportfile->reportfile->lastrowconfig ) {
                    if ( $collectedreportfile->reportfile->lastrowconfig->isLastRow($dynamicrow) ) {
                        if ( ! is_null($last_row) ) {
                            $collectedreportfile->mergeRawValueFromFormatted($last_row);
                        }
                        $last_row = $dynamicrow;
                    } else {
                        $can_merge_this_row = true;
                    }
                } else {
                    $can_merge_this_row = true;
                }

                if ( $can_merge_this_row ) {
                    // merge object (this) formatted values with all rows formatted values
                    $collectedreportfile->mergeRawValueFromFormatted($dynamicrow);
                }
            }
            if ( ! is_null($last_row) ) {
                $collectedreportfile->mergeRawValueFromFormatted($last_row);
            }
            $collectedreportfile->applyFormatFromRaw(null, $collectedreportfile->formatrules);

            return $innertreatment->succeed("Success Merge Collected File " . $collectedreportfile->id);
        } catch (\Exception $e) {
            return $innertreatment->failed( $e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode() );
        }
    }

    /**
     * Format and merge all rows of a given collected file
     * @param Treatment $treatment
     * @param CriticalityLevelEnum $criticalitylevel
     * @param bool $is_last_subtreatment
     * @param bool $can_end_uppertreatment
     * @param CollectedReportFile $collectedreportfile
     * @return InnerTreatment
     */
    public static function fileFormatAndMergeRows(Treatment $treatment, CriticalityLevelEnum $criticalitylevel, bool $is_last_subtreatment, bool $can_end_uppertreatment, CollectedReportFile $collectedreportfile): InnerTreatment
    {
        return self::fileMergeRows($treatment, $criticalitylevel, $is_last_subtreatment, $can_end_uppertreatment, $collectedreportfile, true, true);
    }

    /**
     * Format and merge all values of a given row
     * @param Treatment $treatment
     * @param CriticalityLevelEnum $criticalitylevel
     * @param bool $is_last_subtreatment
     * @param bool $can_end_uppertreatment
     * @param DynamicRow $dynamicrow
     * @param bool $format_values
     * @return InnerTreatment
     */
    public static function rowFormatAndMergeValues(Treatment $treatment, CriticalityLevelEnum $criticalitylevel, bool $is_last_subtreatment, bool $can_end_uppertreatment, DynamicRow $dynamicrow, bool $format_values): InnerTreatment
    {
        $innertreatment = new InnerTreatment($treatment, TreatmentCodeEnum::MERGEFORMATTEDROW, $criticalitylevel, $is_last_subtreatment, $can_end_uppertreatment, false, "Row: " . $dynamicrow->id,);

        try {
            // reset rawvalue from formatted values
            $dynamicrow->resetRawValues();

            // get all dynamicvalues attached to this row
            $dynamicvalues = $dynamicrow->dynamicvalues;

            foreach ($dynamicvalues as $dynamicvalue) {
                // apply formating (without rule) for each value
                if ( $format_values ) {
                    $dynamicvalue->resetRawValues();
                    $dynamicvalue->applyFormatFromRaw($dynamicvalue->getValue(), $dynamicvalue->getFormatRulesForNotification($dynamicrow->hasdynamicrow), true);
                }
                if ($dynamicvalue->dynamicattribute->can_be_notified) {
                    // merge each row (this one) formatted value with all dynamic values formatted values
                    $dynamicrow->mergeRawValueFromFormatted($dynamicvalue);
                }
            }
            $dynamicrow->applyFormatFromRaw(null, $dynamicrow->formatrules, true);

            return $innertreatment->succeed("Success Merge Row");
        } catch (\Exception $e) {
            $error_msg = $e->getMessage() . "; \n" . "File: " . $e->getFile() . "; \n" . "Line: " . $e->getLine() . "; \n" . "Code: " . $e->getCode();
            \Log::error( $error_msg );
            return $innertreatment->failed( $error_msg );
        }
    }
}
