<?php

namespace App\Traits\ReportTreatment\Step;

use App\Models\DynamicValue\DynamicRow;
use App\Models\Treatments\Treatment;
use App\Models\ReportFile\CollectedReportFile;
use App\Traits\ReportTreatment\TreatmentService;

trait TreatmentStepService
{
    use TreatmentService;

    //private ReportTreatmentStep $_step;

    /*public function __construct(ReportTreatmentStep $step)
    {
        $this->setStep($step);
    }


    public function treatment(): IHasTreatmentResults {
        return $this->getStep();
    }

    public function treatmentName(): string {
        return $this->getStep()->name;
    }
    public function treatmentId(): int {
        return $this->getStep()->id;
    }*/

    /*public static function dispatch(Treatment $treatment) {
        $treatment->service->setQueueCode(self::getQueueCode())->fresh();
        dispatch(new TreatmentStepJob($treatment->service->reportfile,  $treatment,  $treatment->service->queue_code, $treatment->is_last_subtreatment, $treatment->can_end_uppertreatment));
    }*/

    /*public function setStep(ReportTreatmentStep $step): void
    {
        $this->_step = $step;
    }

    public function getStep(): ReportTreatmentStep
    {
        return $this->_step;
    }

    public function getFile(): ReportFile
    {
        return $this->_file;
    }*/

    public static function setDynamicRowFromPayload(Treatment $treatment) {
        if ( is_null($treatment->service->dynamicrow) ) {
            $treatment->service->setDynamicRow( DynamicRow::getById( (int) $treatment->getPayloadEntry("rowId") ) );
        }
    }

    public static function setCollectedReportFileFromPayload(Treatment $treatment) {
        if ( is_null($treatment->service->dynamicrow) ) {
            $treatment->service->setCollectedReportFile( CollectedReportFile::getById( (int) $treatment->getPayloadEntry("collectedReportFileId") ) );
        }
    }
}
