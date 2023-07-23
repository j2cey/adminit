<?php

namespace App\Traits\ReportTreatmentResult;

use Illuminate\Support\Carbon;
use App\Enums\TreatmentStepCode;
use App\Enums\TreatmentStateEnum;
use App\Enums\TreatmentResultEnum;
use App\Enums\CriticalityLevelEnum;
use Illuminate\Database\Query\Builder;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * @property string $name
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property string|TreatmentResultEnum $result
 * @property string|TreatmentStateEnum $state
 * @property string|TreatmentStepCode $code
 * @property string|CriticalityLevelEnum $criticality_level
 * @property string $message
 *
 * @method static Builder waiting()
 * @method static Builder notQueued()
 * @method static Builder queued()
 * @method static Builder notRunning()
 * @method static Builder running()
 * @method static Builder notCompleted()
 * @method static Builder completed()
 * @method static Builder notAlltried()
 * @method static Builder retrying()
 * @method static Builder failed()
 * @method static Builder notFailed()
 * @method static Builder success()
 * @method static Builder runningOrRetrying()
 */
trait IsReportTreatment
{
    #region Accessors & Mutators

    public function getIsWaitingAttribute() {
        return ($this->state == TreatmentStateEnum::WAITING);
    }
    public function getIsQueuedAttribute() {
        return ($this->state == TreatmentStateEnum::QUEUED);
    }
    public function getIsRunningAttribute() {
        return ($this->state == TreatmentStateEnum::RUNNING);
    }

    public function getIsRetryingAttribute() {
        return ($this->state == TreatmentStateEnum::RETRYING);
    }
    public function getIsCompletedAttribute() {
        return ($this->state == TreatmentStateEnum::COMPLETED);
    }
    public function getIsSuccessAttribute() {
        return ($this->result == TreatmentResultEnum::SUCCESS);
    }
    public function getIsFailedAttribute() {
        return ($this->result == TreatmentResultEnum::FAILED);
    }
    public function getIsHighCriticalAttribute() {
        return ($this->criticality_level == CriticalityLevelEnum::HIGH);
    }
    public function getCanBeExecutedAttribute()
    {
        if ( ! ($this->isWaiting || $this->isQueued) ) {
            \Log::info("Treatment " . $this->id . " cant be executed as it is Not Waiting or Queued");
            return false;
        } else {
            return true;
        }
    }

    #endregion

    #region Scopes

    public function scopeWaiting($query) {
        return $query
            ->where('state', TreatmentStateEnum::WAITING->value);
    }

    public function scopeNotQueued($query) {
        return $query
            ->whereNotIn('state', [TreatmentStateEnum::QUEUED->value]);
    }

    public function scopeQueued($query) {
        return $query
            ->whereIn('state', [TreatmentStateEnum::QUEUED->value]);
    }

    public function scopeNotRunning($query) {
        return $query
            ->whereNotIn('state', [TreatmentStateEnum::RUNNING->value]);
    }

    public function scopeRunning($query) {
        return $query
            ->whereIn('state', [TreatmentStateEnum::RUNNING->value]);
    }

    public function scopeRetrying($query) {
        return $query
            ->whereIn('state', [TreatmentStateEnum::RETRYING->value]);
    }

    public function scopeNotCompleted($query) {
        return $query
            ->whereNotIn('state', [TreatmentStateEnum::COMPLETED->value]);
    }

    public function scopeCompleted($query) {
        return $query
            ->where('state', TreatmentStateEnum::COMPLETED->value);
    }

    public function scopeNotAlltried($query) {
        return $query
            ->whereNotIn('state', [TreatmentStateEnum::ALLTRIED->value]);
    }

    public function scopeFailed($query) {
        return $query
            ->where('result', TreatmentResultEnum::FAILED->value);
    }

    public function scopeNotFailed($query) {
        return $query
            ->whereNotIn('result', [TreatmentResultEnum::FAILED->value]);
    }

    public function scopeSuccess($query) {
        return $query
            ->where('result', TreatmentResultEnum::SUCCESS->value);
    }

    #endregion

    #region State management Functions
    public function setQueued(bool $save = true) {
        $this->state = TreatmentStateEnum::QUEUED;

        if ( $save ) $this->save();
    }

    public function setStarting(bool $save = true) {

        if ( is_null($this->start_at) ) {
            $this->start_at = Carbon::now();
            if ($save) $this->save();
        }
    }

    public function setEnding(TreatmentResultEnum $treatmentresultenum, string $message = null, bool $complete_treatment = false) {

        $previous_result = $this->result;
        $this->setResult($treatmentresultenum, $message);

        if ($complete_treatment) {
            $this->state = TreatmentStateEnum::COMPLETED;
            $this->end_at = Carbon::now();

            // for the first time, we can increase attempts
            if ($this->attempts === 0) {
                $this->incrementAttempts(false);
            } else {
                // for the others, we increase only if the previous result is failed
                if ($previous_result === TreatmentResultEnum::FAILED) {
                    $this->incrementAttempts(false);
                }
            }

            $this->updateRetries();
        } else {
            $this->setWaiting(false);
            if ($this->isFailed) {
                $this->incrementAttempts(false);
            }
        }

        $this->save();
    }

    public function setResult(TreatmentResultEnum $treatmentresultenum, string $message = null, bool $save = true) {
        $this->result = $treatmentresultenum;
        if ( ! is_null($message) ) {
            $this->message = $message;
        }

        if ($save) $this->save();
    }

    public function incrementAttempts(bool $save = true) {
        if ( ($this->isFailed && $this->isWaiting) || $this->isCompleted ) {
            $this->attempts += 1;
            if ($save) $this->save();
        }
    }

    public function setRunning(bool $save = true) {
        if ( ! $this->isRunning ) {
            $this->state = TreatmentStateEnum::RUNNING;

            if ($save) $this->save();
        }
    }

    public function setRunningOrRetrying(bool $save = true) {
        if ( (! $this->isRunning) && (! $this->isRetrying) ) {
            if ( $this->retries_session_count > 0 ) {
                $this->setRetrying($save);
            } else {
                $this->setRunning($save);
            }
        }
    }

    public function setRetrying(bool $save = true) {
        if ( ! $this->isRetrying ) {
            $this->state = TreatmentStateEnum::RETRYING;

            if ($save) $this->save();
        }
    }

    public function setWaiting(bool $save = true) {
        $this->state = TreatmentStateEnum::WAITING;

        if ( $save ) $this->save();
    }

    public function setEnd(bool $save = true) {
        $this->end_at = Carbon::now();
        $this->state = TreatmentStateEnum::COMPLETED;

        if ( $save ) $this->save();
    }
    public function setFailed(string $message, bool $save = true) {

        $this->result = TreatmentResultEnum::FAILED;
        $this->state = TreatmentStateEnum::WAITING;

        $this->setMessage($message);

        if ( $save ) $this->save();
    }

    public function setMessage(string $message, bool $save = true) {
        $this->message = $message;

        if ( $save ) $this->save();
    }

    /**
     * Update retries infos
     * @return void
     */
    public function updateRetries() {
        if ( $this->attempts > 1 ) {

            // La deuxieme tentative marque le debtut des reessais
            if ( $this->attempts === 2 ) {
                $this->retry_start_at = Carbon::now();
            }

            $max_retries = config('Settings.reporttreatment.max_retries');

            if ( $this->retries_session_count >= $max_retries ) {
                $this->state = TreatmentStateEnum::ALLTRIED;
            }

            $this->retries_session_count += 1;
            $this->retry_end_at = Carbon::now();

            $this->save();
        }
    }

    public function addToPayload(string $key, mixed $value) {
        $payload_arr = [];
        if ( ! is_null($this->payload) ) {
            $payload_arr = json_decode($this->payload, true);
        }
        $payload_arr[$key] = $value;

        $this->payload = json_encode($payload_arr);

        $this->save();
    }
    public function getPayloadEntry(string $key) {
        if ( is_null($this->payload) ) {
            return null;
        }
        $payload_arr = json_decode($this->payload, true);
        if ( ! array_key_exists($key, $payload_arr) ) {
            return null;
        }
        return $payload_arr[$key];
    }
    #endregion
}
