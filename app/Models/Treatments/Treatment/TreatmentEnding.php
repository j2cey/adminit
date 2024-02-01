<?php

namespace App\Models\Treatments\Treatment;

use App\Models\SystemLog;
use App\Services\ExecTrace;
use App\Jobs\TreatmentEndingJob;
use App\Enums\CriticalityLevelEnum;
use App\Models\Treatments\Treatment;
use App\Models\Treatments\TreatmentResult;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Enums\Treatments\TreatmentStateEnum;
use App\Enums\Treatments\TreatmentResultEnum;

trait TreatmentEnding
{
    public static string $TREATMENT_ENDING_LOG_INFO_PART = "treatmentending";

    public function setEnding(Treatment|null $child_treatment) {
        if ( is_null($child_treatment) ) {
            $this->setState(TreatmentStateEnum::FIRSTENDING);
        } else {
            $this->setState(TreatmentStateEnum::ENDING);
        }
    }

    public function setEnded(Treatment|null $child_treatment, TreatmentResult|null $prev_treatmentresult, TreatmentResultEnum $treatmentresultenum, string|null $message, bool $complete_treatment) {
        SystemLog::infoTreatments("setEnded; result: " . $treatmentresultenum->value . "; message: " . $message . "; completed: " . ($complete_treatment ? "yes" : "no"), self::$TREATMENT_ENDING_LOG_INFO_PART);
        $this->treatmentresult->setEnded($child_treatment, $prev_treatmentresult, $treatmentresultenum, $message, $complete_treatment);
    }

    public function preEnding(TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, bool $child_completed = false): bool {
        return $this->treatmenttype_class::preEnding($this, $treatmentresultenum, $child_treatment, $child_completed);
    }

    public function defaultPreEnding(TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, bool $child_completed = false): bool {
        if ( is_null($child_treatment) ) {
            // Direct Ending
            return $this->isReadyToBeCompleted($treatmentresultenum);
        } else {
            // Ending from child
            $this->fresh();
            //SystemLog::infoTreatments("Parent ending; child_can_end_upper_treatment: " . $child_treatment->can_end_uppertreatment . "; all_sub_treatments_launched: " . $this->all_subtreatments_launched, self::$TREATMENT_ENDING_LOG_INFO_PART);
            return $child_treatment->isReadyToBeCompleted($treatmentresultenum) && $child_treatment->isLastTreatmentToProcess() && $child_treatment->can_end_uppertreatment && $this->all_subtreatments_launched;
        }
    }

    public function ending(TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null): TreatmentResultEnum {

        if ( ! $this->isEnding ) {
            $this->setEnding($child_treatment);
            //event(new TreatmentEndingEvent($this, $treatmentresultenum, $message, $child_treatment));
            //dispatch(new TreatmentEndingJob($this, $treatmentresultenum, $message, $child_treatment));
            $this->doEnding($treatmentresultenum, $message, $child_treatment);
        }

        return $treatmentresultenum;
    }

    public function endingWithSuccess(string $message = null): TreatmentResultEnum {
        return $this->ending(TreatmentResultEnum::SUCCESS,null, $message);
    }
    public function endingWithFailure(string $message): TreatmentResultEnum {
        return $this->ending(TreatmentResultEnum::FAILED,null, $message);
    }

    public function postEnding(TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {
        $this->treatmenttype_class::postEnding($this, $treatmentresultenum, $child_treatment, $message, $complete_treatment);
        $this->service->postEnding($this, $treatmentresultenum, $child_treatment, $message, $complete_treatment);
    }

    public function isLastTreatmentToProcess(): bool {

        if ( is_null($this->uppertreatment) ) {
            return true;
        }

        return $this->uppertreatment->subTreatmentsToProcessOrProcessingCount() <= 0;
    }

    /**
     * Determine les condition de fin d traitement PAR DEFAUT
     * @param TreatmentResultEnum $treatmentresultenum
     * @return bool
     */
    public function isReadyToBeCompleted(TreatmentResultEnum $treatmentresultenum) : bool {
        if ($treatmentresultenum == TreatmentResultEnum::SUCCESS) {
            return true;
        }

        return !($this->criticality_level === CriticalityLevelEnum::HIGH);
    }

    /**
     * Exec all ending instructions
     * @return void
     */
    public function doEnding(TreatmentResultEnum $treatmentresult, string|null $message, Treatment|null $child_treatment, bool $child_completed = false) {
        SystemLog::infoTreatments("Ending, " . $this->type->value . " treatment: " . $this->name . "(" . $this->id . ")", self::$TREATMENT_ENDING_LOG_INFO_PART);

        $prev_treatmentresult = $this->treatmentresult;
        //$child_treatment = is_null($event->childtreatmentId) ? null : Treatment::getById($event->childtreatmentId);
        // 1. Perform PRE-Ending if any
        $complete_treatment = $this->preEnding($treatmentresult, $child_treatment, $child_completed);

        // 2. set ending this treatment
        $this->setEnded($child_treatment, $prev_treatmentresult, $treatmentresult, $message, $complete_treatment);

        $this->postEnding($treatmentresult, $child_treatment, $message, $complete_treatment);

        // 3. update state from children if any
        if ( ! is_null($child_treatment) ) {
            $this->updateStateFromSubs();
        }

        // 4. set ending upper treatment
        $this->uppertreatment?->ending($treatmentresult, $this, $message);

        ExecTrace::dispatch($this, TreatmentCodeEnum::ENDING,"ending" . ( is_null($child_treatment) ? " SELF" : " from CHILD: " . $child_treatment->name . " (" . $child_treatment->id . ")" ) , "result: " . $treatmentresult->value . ", completed: " . ($complete_treatment ? "YES" : "NO") . ", Child result: " . $child_treatment?->treatmentresult?->result?->value . ", Child state: " . $child_treatment?->state?->value );
    }

    private function updateStateFromSubs() {
        if ( $this->subtreatments()->retrying()->count() > 0 ) {
            $this->setRetrying(true); return;
        }
        if ( $this->subtreatments()->running()->count() > 0 ) {
            $this->setRunning(); return;
        }
        if ( $this->subtreatments()->queued()->count() > 0 ) {
            $this->setQueued(); return;
        }
        if ( $this->subtreatments()->waiting()->count() > 0 ) {
            $this->setWaiting();
        }
    }
}
