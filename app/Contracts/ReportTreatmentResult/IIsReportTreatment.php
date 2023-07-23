<?php

namespace App\Contracts\ReportTreatmentResult;

use App\Enums\TreatmentResultEnum;

/**
 * @property boolean $isWaiting
 * @property boolean $isQueued
 * @property boolean $isRunning
 * @property boolean $isRetrying
 * @property boolean $isCompleted
 * @property boolean $isSuccess
 * @property boolean $isFailed
 * @property boolean $isHighCritical
 * @property boolean $canBeExecuted
 */
interface IIsReportTreatment
{
    #region Accessors & Mutators

    public function getIsWaitingAttribute();
    public function getIsQueuedAttribute();
    public function getIsRunningAttribute();
    public function getIsCompletedAttribute();
    public function getIsSuccessAttribute();
    public function getIsFailedAttribute();
    public function getIsHighCriticalAttribute();
    public function getCanBeExecutedAttribute();

    #endregion

    #region State management Functions

    public function setStarting(bool $save = true);
    public function setEnding(TreatmentResultEnum $treatmentresultenum, string $message, bool $complete_treatment = false);
    public function setQueued(bool $save = true);
    public function setRunning(bool $save = true);
    public function setRetrying(bool $save = true);
    public function setRunningOrRetrying(bool $save = true);
    public function setWaiting(bool $save = true);
    public function setEnd(bool $save = true);
    public function setMessage(string $message, bool $save = true);
    public function updateRetries();
    public function addToPayload(string $key, mixed $value);

    #endregion
}
