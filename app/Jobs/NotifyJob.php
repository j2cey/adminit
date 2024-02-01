<?php

namespace App\Jobs;

use App\Enums\QueueEnum;
use Illuminate\Bus\Queueable;
use App\Enums\NotificationTypeEnum;
use App\Models\Treatments\Treatment;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportFile\NotifyReport;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notify\NotificationResult;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ReportFile\ReportFileReceiver;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\ReportFile\CollectedReportFile;

class NotifyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $_treatment_id;
    public NotificationTypeEnum $_notificationtype;
    public int $_collectedreportfile_id;
    public int $_receiver_id;

    public int $_sub_notification_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Treatment $treatment, NotificationTypeEnum $notificationtype, CollectedReportFile $collectedreportfile, ReportFileReceiver $receiver)
    {
        \Log::info("NotifyJob __construct - treatment: " . $treatment->id . ", collectedreportfile: " . $collectedreportfile->id . ", receiver : " . $receiver->id);
        $this->onQueue(QueueEnum::NOTIFYFILE->value);

        $this->_sub_notification_id = $treatment->service->collectedreportfile->startingSubNotification($notificationtype, 1)->id;

        $this->_treatment_id = $treatment->id;
        $this->_notificationtype = $notificationtype;
        $this->_collectedreportfile_id = $collectedreportfile->id;
        $this->_receiver_id = $receiver->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $treatment = Treatment::getById($this->_treatment_id);
        $receiver = ReportFileReceiver::getById($this->_receiver_id);
        $sub_notification = NotificationResult::getById($this->_sub_notification_id);
        $collectedreportfile = CollectedReportFile::getById($this->_collectedreportfile_id);

        \Log::info("NotifyJob handle - treatment: " . $treatment->id . ", collectedreportfile: " . $collectedreportfile->id . ", receiver : " . $receiver->id);

        Mail::to($receiver->emailaddress->email)
            ->send(new NotifyReport($collectedreportfile));

        $sub_notification->itemNotificationSucceed(1);
        $collectedreportfile->reloadNotificationResult();

        \Log::info("NotifyJob handle - collectedreportfile->isNotified: " . ($collectedreportfile->isNotified ? "YES" : "NO") . ", nb_notification_success: " . $collectedreportfile->notificationresult->nb_notification_success);

        if ($collectedreportfile->isNotified) {
            $treatment->endingWithSuccess("All Notifications Done !");
            $collectedreportfile->resetMatchedAnalysisRules();
        }
    }
}
