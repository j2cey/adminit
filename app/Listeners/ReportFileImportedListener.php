<?php

namespace App\Listeners;

use App\Models\ReportFile\ReportFile;
use App\Events\ReportFileImportedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ReportTreatments\ReportTreatmentResult;

class ReportFileImportedListener implements ShouldQueue
{
    use InteractsWithQueue;

    public string $connection = 'database';

    public $queue = 'importfiles';

    public $tries = 5;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ReportFileImportedEvent $event)
    {
        ReportFile::getById($event->reportfileId)->execTreatment(ReportTreatmentResult::getById($event->reporttreatmentresultId));
    }
}
