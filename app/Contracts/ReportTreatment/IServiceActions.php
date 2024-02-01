<?php

namespace App\Contracts\ReportTreatment;

use App\Enums\QueueEnum;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;

interface IServiceActions
{
    public static function getQueueCode(): ?QueueEnum;
    //public static function dispatch(Treatment $treatment);
    //public function launchExecOpertion(Treatment $treatment, int|null $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $nexttreatment_payloads, bool $dispatch_on_creation): ?Treatment;
    //public function launch(Treatment $treatment): ?Treatment;
    public function exec(): ?Treatment;
    public function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false);

    public function getNextOnSuccess(): ?TreatmentCodeEnum;
    public function launchNextOnSuccess(array $payloads);
    public function getNextOnFailure(): ?TreatmentCodeEnum;
    public function launchNextOnFailure(array $payloads);
}
