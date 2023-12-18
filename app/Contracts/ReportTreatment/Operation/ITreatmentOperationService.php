<?php

namespace App\Contracts\ReportTreatment\Operation;

use App\Enums\QueueEnum;
use App\Contracts\ReportTreatment\IServiceActions;

interface ITreatmentOperationService extends IServiceActions
{
    //public function __construct(TreatmentOperation $operation);
    //public function dispatchTreatment(ReportFile $file, bool $is_last_subtreatment, bool $can_end_uppertreatment, bool $dispatch_next_step);
    //public static function getStepQueueCode(): QueueEnum;
    //public function execOperation(int $file_id, bool $is_last_subtreatment, bool $can_end_uppertreatment) : ?IHasTreatmentResults;
    //public function getStepService(): IIsTreatmentStepService;

    //public function getOperation(): TreatmentOperation;
}
