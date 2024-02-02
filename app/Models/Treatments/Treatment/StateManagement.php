<?php

namespace App\Models\Treatments\Treatment;

use App\Services\Time\Period;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Treatments\TreatmentStateEnum;

/**
 * @property boolean $isNotStarted
 * @property boolean $isWaiting
 * @property boolean $isQueued
 * @property boolean $isPicking
 * @property boolean $isRunning
 * @property boolean $isStarting
 * @property boolean $isRetrying
 * @property boolean $isRunningOrRetrying
 * @property boolean $isFirstEnding
 * @property boolean $isEnding
 * @property boolean $isEndingOnly
 * @property boolean $isCompleted
 * @property boolean $canBeDispatched
 * @property boolean $canBeExecuted
 *
 * @method static Builder notstarted()
 * @method static Builder waiting()
 * @method static Builder notstartedOrWaiting()
 * @method static Builder todispatch()
 * @method static Builder notQueued()
 * @method static Builder queued()
 * @method static Builder notRunning()
 * @method static Builder running()
 * @method static Builder notCompleted()
 * @method static Builder completed()
 * @method static Builder notAlltried()
 * @method static Builder retrying()
 * @method static Builder runningOrRetrying()
 */
trait StateManagement
{
    #region Scopes

    public function scopeNotStarted($query) {
        return $query->where('state', TreatmentStateEnum::NOTSTARTED->value);
    }

    public function scopeWaiting($query) {
        return $query->where('state', TreatmentStateEnum::WAITING->value);
    }

    public function scopeNotstartedOrWaiting($query) {
        return $query->where('state', TreatmentStateEnum::NOTSTARTED->value)->orWhere('state', TreatmentStateEnum::WAITING->value);
    }

    public function scopeTodispatch($query) {
        return $query->where('state', TreatmentStateEnum::TODISPATCH->value);
    }

    public function scopeNotQueued($query) {
        return $query->whereNotIn('state', [TreatmentStateEnum::QUEUED->value]);
    }

    public function scopeQueued($query) {
        return $query->whereIn('state', [TreatmentStateEnum::QUEUED->value]);
    }

    public function scopeNotRunning($query) {
        return $query->whereNotIn('state', [TreatmentStateEnum::RUNNING->value]);
    }

    public function scopeRunning($query) {
        return $query->whereIn('state', [TreatmentStateEnum::RUNNING->value]);
    }

    public function scopeRetrying($query) {
        return $query->whereIn('state', [TreatmentStateEnum::RETRYING->value]);
    }

    public function scopeRunningOrRetrying($query) {
        return $query->whereIn('state', [TreatmentStateEnum::RUNNING->value, TreatmentStateEnum::RETRYING->value]);
    }

    public function scopeNotCompleted($query) {
        return $query->whereNotIn('state', [TreatmentStateEnum::COMPLETED->value]);
    }

    public function scopeCompleted($query) {
        return $query->where('state', TreatmentStateEnum::COMPLETED->value);
    }

    public function scopeNotAlltried($query) {
        return $query->whereNotIn('state', [TreatmentStateEnum::ALLTRIED->value]);
    }

    #endregion

    #region Accessors & Mutators

    public function getIsNotStartedAttribute() {
        return  $this->state == TreatmentStateEnum::NOTSTARTED;
    }

    public function getIsWaitingAttribute() {
        return  $this->state == TreatmentStateEnum::WAITING;
    }
    public function getIsQueuedAttribute() {
        return $this->state == TreatmentStateEnum::QUEUED;
    }
    public function getIsPickingAttribute() {
        return $this->state == TreatmentStateEnum::PICKING;
    }

    public function getIsStartingAttribute() {
        return $this->state == TreatmentStateEnum::STARTING;
    }
    public function getIsRunningAttribute() {
        return $this->state == TreatmentStateEnum::RUNNING;
    }
    public function getIsRetryingAttribute() {
        return $this->state == TreatmentStateEnum::RETRYING;
    }
    public function getIsRunningOrRetryingAttribute() {
        return $this->state == TreatmentStateEnum::RUNNING || $this->state == TreatmentStateEnum::RETRYING;
    }
    public function getIsFirstEndingAttribute() {
        return $this->state == TreatmentStateEnum::FIRSTENDING;
    }
    public function getIsEndingOnlyAttribute() {
        return $this->state == TreatmentStateEnum::ENDING;
    }
    public function getIsEndingAttribute() {
        return $this->state == TreatmentStateEnum::FIRSTENDING || $this->state == TreatmentStateEnum::ENDING;
    }
    public function getIsCompletedAttribute() {
        return $this->state == TreatmentStateEnum::COMPLETED;
    }

    public function getCanBeDispatchedAttribute()
    {
        if ( $this->isNotStarted || $this->isWaiting || is_null($this->state) ) {
            return true;
        } else {
            \Log::error("Treatment " . $this->name . " ( " . $this->id . " ) cant be dispatched as it is Not Waiting");
            return false;
        }
    }
    public function getCanBeExecutedAttribute()
    {
        if (!($this->isNotStarted || $this->isWaiting || $this->isQueued || $this->isPicking)) {
            \Log::error("Treatment " . $this->name . " ( " . $this->id . " ) cant be executed as it is Not Started yet or Not Waiting or Not Queued");
            return false;
        } else {
            return true;
        }
    }

    #endregion

    public function setState(TreatmentStateEnum $state) {
        $this->prev_state = $this->state;
        $this->state = $state->value;
        $this->save();
    }

    public function rewindToPreviousState() {
        $prev_state = $this->prev_state;
        $this->prev_state = $this->state;
        $this->state = $prev_state->value;
        $this->save();
    }

    /*public function setRunningOrRetrying(bool $save) {
        if ( (! $this->isRunning) && (! $this->isRetrying) ) {
            if ( $this->attempts > 0 ) {
                $this->setRetrying($save);
            } else {
                $this->setRunning($save);
            }
        }
    }*/

    private function setStarted() {
        // set Treatment Started
        if ( is_null($this->start_at) ) {
            $this->start_at = Carbon::now();
            $this->save();
        }
        // set Result Started
        if ( is_null($this->treatmentresult->start_at) ) {
            $this->treatmentresult->start_at = Carbon::now();
            $this->treatmentresult->save();
        }
    }

    public function setCompleted() {
        // set Treatment Ended
        $period = Period::start($this->start_at)->end();
        $this->setState(TreatmentStateEnum::COMPLETED);

        $this->end_at = $period->getEndAt();
        $this->duration = $period->getDurationMilliseconds();
        $this->duration_hhmmss = $period->getDurationHhmmss();

        $this->save();
    }

    public function setRunning(bool $save = true) {
        if ( ! $this->isRunning ) {
            $this->setState(TreatmentStateEnum::RUNNING);

            $this->setStarted();

            if ($save) $this->save();
        }
    }

    public function setStarting(bool $save) {
        if ( ! $this->isStarting ) {
            $this->setState(TreatmentStateEnum::STARTING);

            if ($save) $this->save();
        }
    }

    public function setRetrying(bool $save) {
        if ( ! $this->isRetrying ) {
            $this->setState(TreatmentStateEnum::RETRYING);
            $this->retry_start_at = Carbon::now();

            $this->setStarted();

            if ($save) $this->save();
        }
    }

    public function setWaiting(bool $save = true) {
        $this->setState(TreatmentStateEnum::WAITING);

        if ( $save ) $this->save();
    }

    public function queuing(bool $save = true): static
    {
        $this->setQueued();

        //$this->refresh();
        $this->uppertreatment?->queuing($save);

        return $this;
    }

    public function setQueued(): static
    {
        $this->setState(TreatmentStateEnum::QUEUED);

        return $this;
    }
}
