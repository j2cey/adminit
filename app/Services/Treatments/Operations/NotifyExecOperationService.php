<?php

namespace App\Services\Treatments\Operations;

use App\Enums\QueueEnum;
use App\Enums\CriticalityLevelEnum;
use App\Enums\NotificationTypeEnum;
use Illuminate\Support\Facades\Mail;
use App\Models\Treatments\Treatment;
use App\Mail\ReportFile\NotifyReport;
use App\Services\Treatments\TreatmentStage;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Models\ReportFile\ReportFileReceiver;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Services\Treatments\Steps\NotifyFileStepService;
use App\Traits\ReportTreatment\Operation\TreatmentOperationService;
use App\Contracts\ReportTreatment\Operation\ITreatmentOperationService;

class NotifyExecOperationService implements ITreatmentOperationService
{
    use TreatmentOperationService;

    public ?TreatmentStage $stage;

    public Treatment $treatment;
    public int $exec_id;
    public Treatment $importTreatment;

    public ReportFileReceiver $receiver;

    public function __construct(Treatment $treatment)
    {
        $this->treatment = $treatment;
        $this->exec_id = 0;
        $this->receiver = ReportFileReceiver::getById( (int) $this->treatment->getPayloadEntry("receiverId") );
        self::setCollectedReportFileFromPayload($treatment);

        $this->initStages();
    }

    public static function getQueueCode(): QueueEnum
    {
        return NotifyFileStepService::getQueueCode();
    }

    public function initStages() {
        $this->stage = new TreatmentStage($this->treatment, $this, TreatmentCodeEnum::NOTIFYEXEC->toArray()['name'], null, true);
        $this->stage->setFunction("sendNotification", CriticalityLevelEnum::HIGH, $this->treatment->is_last_subtreatment, $this->treatment->can_end_uppertreatment, ['receiver' => $this->receiver], "Send Notifications to " . $this->receiver->person->fullName);
    }

    public function exec(): ?Treatment {
        if (!$this->treatment->canBeExecuted) {
            return $this->treatment;
        }

        $this->treatment->starting();
        $this->stage->exec($this->treatment->break_point);

        return $this->treatment;
    }

    /**
     * @param CriticalityLevelEnum $criticality_level
     * @param bool $is_last_subtreatment
     * @param bool $can_end_uppertreatment
     * @param ReportFileReceiver $receiver
     * @return int
     */
    public function sendNotification(CriticalityLevelEnum $criticality_level, bool $is_last_subtreatment, bool $can_end_uppertreatment, ReportFileReceiver $receiver): int
    {
        $sub_notification = $this->treatment->service->collectedreportfile->startingSubNotification(NotificationTypeEnum::EMAIL, 1);

        Mail::to($receiver->emailaddress->email)
            ->send(new NotifyReport($this->treatment->service->collectedreportfile));
        $sub_notification->itemNotificationSucceed(1);

        $this->treatment->endingWithSuccess("Success Notification ! For " . $receiver->person->fullName);

        if ($this->treatment->service->collectedreportfile->isNotified) {
            $this->treatment->uppertreatment->endingWithSuccess("All Notifications Done !");
            $this->treatment->service->collectedreportfile->resetMatchedAnalysisRules();
        }

        return 1;
    }

    public function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

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

    /*public function launch(Treatment $treatment): ?Treatment
    {
        return null;
    }*/
}
