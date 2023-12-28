<?php

namespace App\Listeners;

use App\Events\LaunchTreatmentEvent;
use App\Models\ReportFile\ReportFile;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Treatments\Treatment;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Enums\Treatments\TreatmentStateEnum;

class LaunchTreatmentListener
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
     * @param LaunchTreatmentEvent $event
     * @return void
     */
    public function handle(LaunchTreatmentEvent $event)
    {
        $treatment = Treatment::getById($event->treatmentId);
        $reportfile = ReportFile::getById($event->reportfileId);
        if ( is_null($treatment) ) {
            \Log::error("LaunchTreatmentListener. Treatment NOT FOUND");
        }
        if ( is_null($treatment->service) ) {
            \Log::error("LaunchTreatmentListener. Sevice NOT YET CREATED for " . $treatment->type->value . " " . $treatment->name . " ( " . $treatment->id . " )");
            $treatment->setState(TreatmentStateEnum::TODISPATCH);
            return;
        }
        if ( $treatment->dispatch_on_creation ) {
            $treatment->service->dispatch($reportfile);
        }
    }
}
