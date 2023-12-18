<?php

namespace App\Services\Operations;

use App\Enums\NotificationTypeEnum;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportFile\NotifyReport;
use App\Models\ReportTreatments\Treatment;
use App\Services\Steps\NotifyFileStepService;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Traits\ReportTreatment\Operation\TreatmentOperationService;
use App\Contracts\ReportTreatment\Operation\ITreatmentOperationService;

class NotifyFileExecService extends NotifyFileStepService implements ITreatmentOperationService
{
    use TreatmentOperationService;

    public static function launch(Treatment $treatment): ?Treatment  {
        return self::exec($treatment);
    }

    public static function exec(Treatment $treatment): ?Treatment
    {
        $treatment->refresh();
        if (  ! $treatment->canBeExecuted ) {
            return $treatment;
        }

        self::setCollectedReportFileFromPayload($treatment);
        $treatment->starting();
        //self::startNotification($treatment, CriticalityLevelEnum::HIGH, false, false);

        if (count($treatment->service->collectedreportfile->matchedanalysisrules) > 0) {
            $receivers = $treatment->service->getReportfile()->receivers;

            $main_notificationresult = $treatment->service->collectedreportfile->startingNotification(count($receivers),null);

            foreach ($receivers as $receiver) {
                $sub_notification = $main_notificationresult->startingSubNotification(NotificationTypeEnum::EMAIL, 1, false);
                Mail::to($receiver->emailaddress->email)
                    ->send(new NotifyReport($treatment->service->collectedreportfile));
                $sub_notification->itemNotificationSucceed(1);
            }

            $treatment->service->collectedreportfile->resetMatchedAnalysisRules();

            if ($treatment->service->collectedreportfile->isNotified) {
                $treatment->endingWithSuccess("Success Notification !");
            } else {
                $treatment->endingWithFailure("Error Notification. " . $treatment->service->collectedreportfile->notificationresult->last_failed_message);
            }
        } else {
            $treatment->endingWithSuccess("Nothing to Notify");
        }

        //self::endNotification($treatment, CriticalityLevelEnum::HIGH, true, true);

        return $treatment;
    }

    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }
}
