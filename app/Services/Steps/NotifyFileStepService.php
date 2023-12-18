<?php

namespace App\Services\Steps;

use App\Enums\QueueEnum;
use Illuminate\Support\Carbon;
use App\Services\InnerTreatment;
use App\Enums\CriticalityLevelEnum;
use App\Models\ReportTreatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Traits\ReportTreatment\Step\TreatmentStepService;
use App\Contracts\ReportTreatment\Step\ITreatmentStepService;

class NotifyFileStepService implements ITreatmentStepService
{
    use TreatmentStepService;

    public static function getQueueCode(): QueueEnum
    {
        return QueueEnum::NOTIFYFILE;
    }

    public static function launchExecOpertion(Treatment $treatment, int|null $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $nexttreatment_payloads, bool $dispatch_on_creation): ?Treatment {
        return $treatment->launchNewSubOperation(TreatmentCodeEnum::NOTIFYFILE_EXEC, CriticalityLevelEnum::HIGH, $exec_id ?? 1, true, true, $nexttreatment_payloads, $dispatch_on_creation,false, false, null);
    }

    public static function launch(Treatment $treatment): ?Treatment {
        // Launch the step (operation) executor.
        $payloads = [];// ['collectedReportFileId' => $treatment->getMainTreatment()->collectedreportfile->id];
        return self::launchExecOpertion($treatment, null, true, true, $payloads, true);
    }

    public static function exec(Treatment $treatment): ?Treatment {
        if ( $treatment->subtreatments()->waiting()->count() > 0 ) {
            $treatment->firstWaitingSubTreatment()->service->dispatch($treatment->reportfile);

            return $treatment;
        }
        //ConsoleLog::info("DownloadFileStepService executed - Nothing to do");
        return $treatment;
    }

    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }
}
