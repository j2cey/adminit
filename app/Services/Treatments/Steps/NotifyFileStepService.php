<?php

namespace App\Services\Treatments\Steps;

use App\Jobs\NotifyJob;
use App\Enums\QueueEnum;
use App\Enums\CriticalityLevelEnum;
use App\Enums\NotificationTypeEnum;
use Illuminate\Support\Facades\Mail;
use App\Models\Treatments\Treatment;
use App\Mail\ReportFile\NotifyReport;
use App\Services\Treatments\TreatmentStage;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Models\ReportFile\ReportFileReceiver;
use App\Traits\ReportTreatment\Step\TreatmentStepService;
use App\Contracts\ReportTreatment\Step\ITreatmentStepService;
use function dispatch;

class NotifyFileStepService implements ITreatmentStepService
{
    use TreatmentStepService;

    public ?TreatmentStage $stage;

    public Treatment $treatment;
    public int $exec_id;
    public Treatment $importTreatment;

    public array $receivers = [];

    public function __construct(Treatment $treatment)
    {
        $this->treatment = $treatment;
        $this->exec_id = 0;
        self::setCollectedReportFileFromPayload($treatment);

        $this->initStages();
    }

    public function initStages() {
        $this->stage = new TreatmentStage($this->treatment, $this, TreatmentCodeEnum::NOTIFYFILE->toArray()['name'], null, true);
        $this->stage->setFunction("launchNotifications", CriticalityLevelEnum::HIGH, $this->treatment->is_last_subtreatment, $this->treatment->can_end_uppertreatment, null, "Launch Notifications");
    }

    /*public function initStages_old() {
        $receivers = $this->treatment->service->getReportfile()->receivers;

        if (count($receivers) > 0) {
            $last_stage = $this->stage = new TreatmentStage($this->treatment, $this, TreatmentCodeEnum::DOWNLOADFILE->toArray()['name'], null, true);
            foreach ($receivers as $key => $receiver) {
                if ($key == 0) {
                    $last_stage->setFunction("sendNotifications", $this->treatment->criticality_level, $this->treatment->is_last_subtreatment, $this->treatment->can_end_uppertreatment, ['receiver' => $receiver], "Send Notifications to " . $receiver->person->fullName);
                } else {
                    $last_stage = $last_stage
                        ->addNextStageOnSuccess(TreatmentCodeEnum::DOWNLOADFILE->toArray()['name'], true, "sendNotifications", $this->treatment->criticality_level, $this->treatment->is_last_subtreatment, $this->treatment->can_end_uppertreatment, ['receiver' => $receiver], "Send Notifications to " . $receiver->person->fullName);
                }
            }
        }
    }*/

    public static function getQueueCode(): QueueEnum
    {
        return QueueEnum::NOTIFYFILE;
    }

    /*public static function launchExecOpertion(Treatment $treatment, int|null $exec_id, bool $is_last_subtreatment, bool $can_end_uppertreatment, array $nexttreatment_payloads, bool $dispatch_on_creation): ?Treatment {
        return $treatment->launchNewSubOperation(TreatmentCodeEnum::NOTIFYEXEC, CriticalityLevelEnum::HIGH, $exec_id ?? 1, true, true, $nexttreatment_payloads, $dispatch_on_creation,false, false, null);
    }*/

    /*public function launch(Treatment $treatment): ?Treatment {
        // Launch the step (operation) executor.
        $payloads = [];// ['collectedReportFileId' => $treatment->getMainTreatment()->collectedreportfile->id];
        return self::launchExecOpertion($treatment, null, true, true, $payloads, true);
    }*/

    public function exec(): ?Treatment
    {
        if (!$this->treatment->canBeExecuted) {
            return $this->treatment;
        }

        $this->treatment->starting();

        if (count($this->treatment->service->collectedreportfile->matchedanalysisrules) > 0) {

            $this->stage->exec($this->treatment->break_point);

        } else {
            $this->treatment->endingWithSuccess("Nothing to Notify");
        }

        return $this->treatment;
    }

    public function launchNotifications(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment): int {
        $matchedanalysisrules_count = count($this->treatment->service->collectedreportfile->matchedanalysisrules);
        //\Log::info("launchNotifications, matchedanalysisrules_count: " . $matchedanalysisrules_count);
        if ($matchedanalysisrules_count > 0) {
            $receivers = $this->treatment->service->getReportfile()->receivers;
            $len = count($receivers);
            \Log::info("launchNotifications receivers length: " . $len);
            foreach ($receivers as $index => $receiver) {
                \Log::info("launchNotifications receiver : " . $receiver->id);
                dispatch(new NotifyJob($this->treatment, NotificationTypeEnum::EMAIL, $this->treatment->service->collectedreportfile, $receiver));
                /*$treatment_payloads = ['collectedReportFileId' => $this->treatment->service->collectedreportfile->id, 'receiverId' => $receiver->id, 'notificationType' => NotificationTypeEnum::EMAIL->value];
                if ($index == $len - 1) {
                    $is_last_notification = true;
                } else {
                    $is_last_notification = false;
                }
                $this->treatment->launchNewSubOperation(TreatmentCodeEnum::NOTIFYEXEC, CriticalityLevelEnum::HIGH, $this->treatment->service->getNextExecId(), $is_last_notification, true, $treatment_payloads, true, false, false, null);
                */
            }
        } else {
            $this->treatment->endingWithSuccess("Nothing to Notify");
        }
        return 1;
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

    #region Stage Functions

    /**
     * @param CriticalityLevelEnum $criticality_level
     * @param bool $is_last_subtreatment
     * @param bool $can_end_uppertreatment
     * @param ReportFileReceiver $receiver
     * @return int
     */
    public function sendNotifications(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment, ReportFileReceiver $receiver): int
    {
        $sub_notification = $this->treatment->service->collectedreportfile->startingSubNotification(NotificationTypeEnum::EMAIL, 1);

        Mail::to($receiver->emailaddress->email)
                ->send(new NotifyReport($this->treatment->service->collectedreportfile));
        $sub_notification->itemNotificationSucceed(1);

        return 1;
    }

    public function sendNotifications_old(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment, ReportFileReceiver $receiver): int {
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
