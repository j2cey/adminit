<?php

namespace App\Traits\ReportTreatment\Operation;

use App\Models\ReportFile\ReportFile;
use App\Contracts\ReportTreatment\Step\ITreatmentStepService;

trait TreatmentOperationService
{
    //use IsTreatmentService;

    //private TreatmentOperation $_operation;
    //private ITreatmentStepService $_step_service;

    /*public function __construct(TreatmentOperation $operation)
    {
        $this->setOperation($operation);
        //$this->setStepService($step_service);
        //$this->setQueueCode($step_service::queueCode());
    }

    public function treatment(): IHasTreatmentResults {
        return $this->getOperation() ;
    }

    public function treatmentName(): string {
        return $this->getOperation()->name;
    }

    public function treatmentId(): int {
        return $this->getOperation()->id;
    }*/

    /*public static function dispatch(TreatmentOperation|IHasTreatmentResults $treatment) {
        $treatment->service->setQueueCode(self::getStepQueueCode())->fresh();
        dispatch(new TreatmentOperationJob($treatment->service->getReportFile(), $treatment, $treatment->service->queue_code, $treatment->service->is_last_subtreatment, $treatment->service->can_end_uppertreatment));
    }*/
}
