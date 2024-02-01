<?php

namespace App\Models\Treatments\TreatmentService;

use App\Models\SystemLog;
use App\Jobs\TreatmentJob;
use App\Models\Treatments\Treatment;
use App\Models\ReportFile\ReportFile;
use App\Models\DynamicValue\DynamicRow;
use App\Models\DynamicValue\DynamicValue;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Models\ReportFile\CollectedReportFile;
use function dispatch;

trait ServiceActions
{
    public function dispatch(ReportFile|null $reportfile) {
        if ( $this->treatment->canBeDispatched ) {
            SystemLog::infoTreatments("dispatch service " . $this->serviceactions_class . ", " . $this->treatment->type->value . " treatment: " . $this->treatment->name . "( " . $this->treatment->id . " )" . is_null($reportfile) ? "" : " - file: " . $reportfile->name . "(" . $reportfile->id . ")", self::$TREATMENTSERVICE_LOG_INFO_PART);
            $this->setReportFile($reportfile);
            //$this->serviceactions_class::dispatch($this->treatment);
            dispatch(new TreatmentJob($this->treatment));
        }
    }

    /*public function launchExecOpertion(array $nexttreatment_payloads, int|null $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, bool $dispatch_on_creation): ?Treatment {
        return $this->serviceactions_class::launchExecOpertion($this->treatment, $exec_id, $is_last_subtreatment, $can_end_uppertreatment, $nexttreatment_payloads, $dispatch_on_creation);
    }*/

    public function launch() {
        SystemLog::infoTreatments("launch service " . $this->serviceactions_class . ", " . $this->treatment->type->value . " treatment: " . $this->treatment->name . "( " . $this->treatment->id . " )" . is_null($this->reportfile) ? "" : " - file: " . $this->reportfile->name . "(" . $this->reportfile->id . ")", self::$TREATMENTSERVICE_LOG_INFO_PART);
        $this->serviceactions_class::launch($this->treatment);
    }

    public function exec(string $description = null, ReportFile $reportFile = null, CollectedReportFile $collectedreportfile = null, DynamicRow $dynamicrow = null, DynamicValue $dynamicvalue = null): Treatment|static|null
    {
        //$this->initExec( $description,  $reportFile,  $collectedreportfile,  $dynamicrow,  $dynamicvalue);

        $this->treatment->refresh();
        if (  ! $this->treatment->canBeExecuted ) {
            return $this;
        }

        /*$to_be_launch = $this->treatment->subtreatments()->waiting()->count() === 0 &&
            $this->treatment->subtreatments()->running()->count() === 0 &&
            $this->treatment->subtreatments()->queued()->count() === 0;

        if ( $to_be_launch ) {
            SystemLog::infoTreatments("from EXEC, launch service " . $this->serviceactions_class . ", " . $this->treatment->type->value . " treatment: " . $this->treatment->name . "( " . $this->treatment->id . " )" . is_null($this->reportfile) ? "" : " - file: " . $this->reportfile->name . "(" . $this->reportfile->id . ")", self::$TREATMENTSERVICE_LOG_INFO_PART);
            return $this->serviceactions_class::launch($this->treatment);
        } else {
            SystemLog::infoTreatments("from EXEC service " . $this->serviceactions_class . ", " . $this->treatment->type->value . " treatment: " . $this->treatment->name . "( " . $this->treatment->id . " )" . is_null($this->reportfile) ? "" : " - file: " . $this->reportfile->name . "(" . $this->reportfile->id . ")", self::$TREATMENTSERVICE_LOG_INFO_PART);
            return $this->serviceactions_class::exec($this->treatment);
        }*/
        return $this->getServiceObject()->exec();
    }

    public function getNextOnSuccess(): ?TreatmentCodeEnum {
        return $this->getServiceObject()->getNextOnSuccess();
    }

    public function launchNextOnSuccess(array $payloads) {
        $this->getServiceObject()->launchNextOnSuccess($payloads);
    }

    public function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {
        $this->getServiceObject()->postEnding($treatment, $treatmentresultenum, $child_treatment, $message, $complete_treatment);
    }
}
