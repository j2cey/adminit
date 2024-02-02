<?php

namespace App\Models\Treatments\Treatment;

use App\Models\SystemLog;
use App\Models\Treatments\Treatment;
use App\Services\Treatments\ExecTrace;
use App\Enums\Treatments\TreatmentCodeEnum;

trait TreatmentStarting
{
    public static string $TREATMENT_STARTING_LOG_INFO_PART = "treatmentstarting";

    /**
     * @param Treatment|null $child
     * @return $this
     */
    public function starting(Treatment $child = null): static
    {
        if ( ! $this->isStarting ) {
            $this->setStarting(true);
            //event(new TreatmentStartingEvent($this, $child));
            //dispatch(new TreatmentStartingJob($this, $child));
            $this->doStarting($child);
        }
        return $this;
    }

    /*public function setStarted() {

        $this->setRunning();
        $this->treatmentresult->save();
    }*/

    public function doStarting(Treatment $child_treatment = null) {
        $prev_treatmentresult = $this->treatmentresult;

        // 1. increment attempts if any
        $this->incrementAttempts($child_treatment, true);

        // 2. starting or retrying self (Update starting fields)
        $this->setStartingOrRetrying($child_treatment);

        // 3. start upper treatment
        if ($this->uppertreatment) {
            // Starts upper if not running or retrying
            if ( ! $this->uppertreatment->isRunningOrRetrying ) {
                $this->uppertreatment->starting($this);
            }
        } else {
            SystemLog::infoTreatments("NO UPPER TREATMENT !", Treatment::$TREATMENT_STARTING_LOG_INFO_PART);
        }
        ExecTrace::dispatch($this, TreatmentCodeEnum::STARTING,"starting" . ( is_null($child_treatment) ? " SELF" : " from CHILD: " . $child_treatment->name . " (" . $child_treatment->id . ")" ) , null);
    }

    private function setStartingOrRetrying(Treatment|null $child_treatment) {
        if ( is_null($child_treatment) ) {
            // self starting
            $is_retryng = ( $this->isFailed && $this->attempts > 0 );
        } else {
            // starting from child
            $is_retryng = ( $child_treatment->attempts > 1 );
        }

        if ( $is_retryng ) {
            SystemLog::infoTreatments("Retrying (try: " . $this->attempts . "), treatment " . $this->type->value . ": " . $this->name . "(" . $this->id . ")", Treatment::$TREATMENT_STARTING_LOG_INFO_PART);
            $this->setRetrying(true);
            // create new result
            $this->addResult();
        } else {
            SystemLog::infoTreatments("Starting (try: " . $this->attempts . "), treatment " . $this->type->value . ": " . $this->name . "(" . $this->id . ")", Treatment::$TREATMENT_STARTING_LOG_INFO_PART);
            $this->setStarting(true);
        }
        // set started. Treatment is running now
        $this->setRunning();
    }
}
