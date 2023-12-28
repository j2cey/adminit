<?php

namespace App\Listeners;

use App\Events\TreatmentCreatedEvent;
use App\Models\ReportFile\ReportFile;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Treatments\Treatment;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ReportFile\CollectedReportFile;

class TreatmentCreatedListener
{
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
     * @param TreatmentCreatedEvent $event
     * @return void
     */
    public function handle(TreatmentCreatedEvent $event)
    {
        $treatment = Treatment::getById($event->treatment_id);
        //$treatment->load(['reportfile','collectedreportfile']);
        $treatment->setService($treatment->code, ReportFile::getById($event->reportfile_id), CollectedReportFile::getById($event->collectedreportfile_id));
        $treatment->addResult();
    }
}
