<?php

namespace App\Services\Treatments\Main;

use App\Enums\QueueEnum;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Contracts\ReportTreatment\Main\IMainService;

class MainService implements IMainService
{
    public Treatment $treatment;

    public function __construct(Treatment $treatment)
    {
        $this->treatment = $treatment;
    }

    public static function getQueueCode(): ?QueueEnum
    {
        return QueueEnum::MAIN;
    }

    /*public function launchExecOpertion(Treatment $treatment, int|null $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $nexttreatment_payloads, bool $dispatch_on_creation): ?Treatment
    {
        return null;
    }*/

    /*public function launch(Treatment $treatment): ?Treatment
    {
        return self::exec($treatment);
    }*/

    public function exec(): ?Treatment
    {
        $subs = $this->treatment->subtreatmentswaiting;
        foreach ($subs as $sub) {
            $sub->service->execIdReset();
            $sub->service->dispatch($sub->reportfile);
        }
        return null;
    }

    public function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {
        /*if ( ! is_null($child_treatment) ) {
            $treatment->progressionAddStepDone($child_treatment->name, ($treatmentresultenum->succeed()), "end from Main");
        }*/
    }

    public function getNextOnSuccess(): ?TreatmentCodeEnum {
        return null;
    }

    public function launchNextOnSuccess(array $payloads) {

    }

    public function getNextOnFailure(): ?TreatmentCodeEnum {
        return null;
    }

    public function launchNextOnFailure(array $payloads) {

    }
}
