<?php

namespace App\Listeners;

use App\Models\ReportFile\ReportFile;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ReportFileDownloadedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ReportTreatments\ReportTreatmentResult;

class ReportFileDownloadedListener implements ShouldQueue
{
    use InteractsWithQueue;

    public string $connection = 'database';

    public $queue = 'downloadfiles';

    public $tries = 5;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }


    /**
     * Handle the event.
     *
     * @param  \App\Events\ReportFileDownloadedEvent  $event
     * @return void
     */
    public function handle(ReportFileDownloadedEvent $event)
    {
        ReportFile::getById($event->reportfileId)->execTreatment(ReportTreatmentResult::getById($event->reporttreatmentresultId));
    }
}
