<?php

namespace App\Observers;

use App\Models\Treatments\Treatment;
use App\Enums\Treatments\TreatmentStateEnum;

class TreatmentObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the Treatment "created" event.
     *
     * @param Treatment $treatment
     * @return void
     */
    public function created(Treatment $treatment)
    {
        $treatment->setIsLastSubtreatment($treatment->is_last_subtreatment, $treatment->uppertreatment)
            ->setCanEndUpperTreatment($treatment->can_end_uppertreatment);

        // save as subtreatment
        if ( ! is_null( $treatment->uppertreatment ) ) {
            \Log::info("save as subtreatment");
            $treatment->uppertreatment->saveSubTreatment($treatment);
            //$treatment->setUpperProgression($treatment->uppertreatment?->progression);
        }

        $service = $treatment->setService($treatment->code);
        $treatment->addResult();

        $treatment->setState(TreatmentStateEnum::NOTSTARTED);

        // dispatch treatment if any
        if ( $treatment->dispatch_on_creation ) {
            //$service->treatment()->save($this);
            $service->dispatch($treatment->reportfile);
        }
    }

    /**
     * Handle the Treatment "updated" event.
     *
     * @param Treatment $treatment
     * @return void
     */
    public function updated(Treatment $treatment)
    {
        //
    }

    public function deleting(Treatment $treatment)
    {
        // service
        $treatment->service()->delete();
        // results
        $treatment->treatmentresults()->each(function($treatmentresult) {
            $treatmentresult->delete(); // <-- direct deletion
        });
        /*$treatment->subtreatments()->each(function($subtreatment) {
            $subtreatment->delete(); // <-- direct deletion
        });*/
    }

    /**
     * Handle the Treatment "deleted" event.
     *
     * @param Treatment $treatment
     * @return void
     */
    public function deleted(Treatment $treatment)
    {
        //
    }

    /**
     * Handle the Treatment "restored" event.
     *
     * @param Treatment $treatment
     * @return void
     */
    public function restored(Treatment $treatment)
    {
        //
    }

    /**
     * Handle the Treatment "force deleted" event.
     *
     * @param Treatment $treatment
     * @return void
     */
    public function forceDeleted(Treatment $treatment)
    {
        //
    }
}
