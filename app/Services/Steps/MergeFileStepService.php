<?php

namespace App\Services\Steps;

use App\Enums\QueueEnum;
use App\Services\InnerTreatment;
use App\Enums\CriticalityLevelEnum;
use App\Models\DynamicValue\DynamicRow;
use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Models\ReportFile\CollectedReportFile;
use App\Traits\ReportTreatment\Step\TreatmentStepService;
use App\Contracts\ReportTreatment\Step\ITreatmentStepService;

class MergeFileStepService implements ITreatmentStepService
{
    use TreatmentStepService;

    public static function getQueueCode(): QueueEnum
    {
        return QueueEnum::MERGEFILE;
    }

    public static function launchExecOpertion(Treatment $treatment, int|null $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $nexttreatment_payloads, bool $dispatch_on_creation): ?Treatment {
        return $treatment->launchNewSubOperation(TreatmentCodeEnum::MERGEFILE_EXEC, CriticalityLevelEnum::HIGH, $exec_id ?? 1, true, true, $nexttreatment_payloads, $dispatch_on_creation, false, false, null);
    }

    public static function launch(Treatment $treatment): ?Treatment {
        return self::launchExecOpertion($treatment, null, true, true, [], true);
    }

    public static function exec(Treatment $treatment): ?Treatment {
        //$treatment_payloads = ['collectedReportFileId' => $collectedreportfile->id, 'importTreatmentId' => $this->_treatment_id];
        if ( $treatment->subtreatments()->waiting()->count() > 0 ) {
            $treatment->firstWaitingSubTreatment()->service->dispatch($treatment->reportfile);

            return $treatment;
        }

        return $treatment;
    }

    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }

    public static function getImportTreatment(Treatment $treatment): ?Treatment
    {
        return Treatment::getById( (int) $treatment->getPayloadEntry("importTreatmentId") );
    }

    public static function fileMergeRows(Treatment $treatment, CriticalityLevelEnum $criticalitylevel, bool $is_last_subtreatment, bool $can_end_uppertreatment, CollectedReportFile $collectedreportfile, bool $format_and_merge_rows, bool $format_values): InnerTreatment {
        $innertreatment = new InnerTreatment($treatment, TreatmentCodeEnum::MERGEFORMATTEDFILE, $criticalitylevel, $is_last_subtreatment, $can_end_uppertreatment, true, "File: " . $collectedreportfile->id);

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

                //$collectedreportfile->setRowFormatSuccess($row_index);
            }
            if ( ! is_null($last_row) ) {
                $collectedreportfile->mergeRawValueFromFormatted($last_row);
            }
            $collectedreportfile->applyFormatFromRaw(null, $collectedreportfile->formatrules);

            return $innertreatment->succeed("Success Merge Collected File");
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
        $innertreatment = new InnerTreatment($treatment, TreatmentCodeEnum::MERGEFORMATTEDROW, $criticalitylevel, $is_last_subtreatment, $can_end_uppertreatment, true, "Row: " . $dynamicrow->id,);

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
                    //$dynamicvalue->itemFormattingSucceed(1);
                }
                if ($dynamicvalue->dynamicattribute->can_be_notified) {
                    // merge each row (this one) formatted value with all dynamic values formatted values
                    $dynamicrow->mergeRawValueFromFormatted($dynamicvalue);
                    //$dynamicrow->itemFormattingSucceed($dynamicvalue->dynamicattribute->num_ord);
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
