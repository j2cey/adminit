<?php

namespace App\Observers;

use App\Models\ReportTreatments\TreatmentService;

class TreatmentServiceObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the TreatmentService "created" event.
     *
     * @param TreatmentService $treatmentService
     * @return void
     */
    public function created(TreatmentService $treatmentService)
    {
        //
    }

    /**
     * Handle the TreatmentService "updated" event.
     *
     * @param TreatmentService $treatmentService
     * @return void
     */
    public function updated(TreatmentService $treatmentService)
    {
        //
    }

    /**
     * Handle the TreatmentService "deleted" event.
     *
     * @param TreatmentService $treatmentService
     * @return void
     */
    public function deleted(TreatmentService $treatmentService)
    {
        //
    }

    /**
     * Handle the TreatmentService "restored" event.
     *
     * @param TreatmentService $treatmentService
     * @return void
     */
    public function restored(TreatmentService $treatmentService)
    {
        //
    }

    /**
     * Handle the TreatmentService "force deleted" event.
     *
     * @param TreatmentService $treatmentService
     * @return void
     */
    public function forceDeleted(TreatmentService $treatmentService)
    {
        //
    }
}
