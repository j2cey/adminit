<?php

namespace App\Services\Steps;

use App\Enums\QueueEnum;
use App\Services\TreatmentStage;
use App\Enums\CriticalityLevelEnum;
use App\Enums\NotificationTypeEnum;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportFile\NotifyReport;
use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Traits\ReportTreatment\Step\TreatmentStepService;
use App\Contracts\ReportTreatment\Step\ITreatmentStepService;

class NotifyFileStepService implements ITreatmentStepService
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
        $this->stage->setFunction("sendNotifications", $this->treatment->criticality_level, $this->treatment->is_last_subtreatment, $this->treatment->can_end_uppertreatment, "Send Notifications");
    }

    public static function getQueueCode(): QueueEnum
    {
        return QueueEnum::NOTIFYFILE;
    }

    public static function launchExecOpertion(Treatment $treatment, int|null $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $nexttreatment_payloads, bool $dispatch_on_creation): ?Treatment {
        return $treatment->launchNewSubOperation(TreatmentCodeEnum::NOTIFYFILE_EXEC, CriticalityLevelEnum::HIGH, $exec_id ?? 1, true, true, $nexttreatment_payloads, $dispatch_on_creation,false, false, null);
    }

    public function launch(Treatment $treatment): ?Treatment {
        // Launch the step (operation) executor.
        $payloads = [];// ['collectedReportFileId' => $treatment->getMainTreatment()->collectedreportfile->id];
        return self::launchExecOpertion($treatment, null, true, true, $payloads, true);
    }

    public function exec(): ?Treatment {
        if (!$this->treatment->canBeExecuted) {
            return $this->treatment;
        }

        $this->treatment->starting();

        $this->stage->exec($this->treatment->break_point);

        return $this->treatment;
        /*if ( $treatment->subtreatments()->waiting()->count() > 0 ) {
            $treatment->firstWaitingSubTreatment()->service->dispatch($treatment->reportfile);

            return $treatment;
        }

        return $treatment;
        */
    }

    #region Stage Functions
    public function sendNotifications(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int {
        if (count($this->treatment->service->collectedreportfile->matchedanalysisrules) > 0) {
            $receivers = $this->treatment->service->getReportfile()->receivers;

            $main_notificationresult = $this->treatment->service->collectedreportfile->startingNotification(count($receivers),null);

            foreach ($receivers as $receiver) {
                $sub_notification = $main_notificationresult->startingSubNotification(NotificationTypeEnum::EMAIL, 1, false);
                Mail::to($receiver->emailaddress->email)
                    ->send(new NotifyReport($this->treatment->service->collectedreportfile));
                $sub_notification->itemNotificationSucceed(1);
            }

            $this->treatment->service->collectedreportfile->resetMatchedAnalysisRules();

            if ($this->treatment->service->collectedreportfile->isNotified) {
                $this->treatment->endingWithSuccess("Success Notification !");
            } else {
                $this->treatment->endingWithFailure("Error Notification. " . $this->treatment->service->collectedreportfile->notificationresult->last_failed_message);
            }
        } else {
            $this->treatment->endingWithSuccess("Nothing to Notify");
        }
        return 1;
    }
    #endregion

    public function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }
}
