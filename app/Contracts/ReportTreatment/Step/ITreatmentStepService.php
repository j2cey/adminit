<?php

namespace App\Contracts\ReportTreatment\Step;

use App\Models\Treatments\Treatment;
use App\Contracts\ReportTreatment\IServiceActions;

interface ITreatmentStepService extends IServiceActions
{
    //public static function launchExecOpertion(Treatment $treatment): ?Treatment;
    //public function getJob(ReportFile $file, ReportTreatmentStep $step, bool $dispatch_next_step) : ShouldQueue;
    //public function dispatchTreatment(ReportFile $file, bool $is_last_subtreatment, bool $can_end_uppertreatment, bool $dispatch_next_step);

    //public static function getQueueCode(): QueueEnum;
    //public function execStep(int $file_id, bool $is_last_subtreatment, bool $can_end_uppertreatment) : ?IHasTreatmentResults;
    //public static function queueCode(): QueueEnum;
    //public function getStep(): ReportTreatmentStep;
}
