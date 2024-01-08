<?php

namespace App\Models\Treatments\Treatment;

use App\Models\Treatments\Treatment;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Treatments\TreatmentCodeEnum;

/**
 * @property int $subsWaitingCount
 * @property int $subsQueuedCount
 * @property int $subsRunningCount
 * @property int $subsRetryingCount
 * @property int $subsSuccessCount
 * @property int $subsFailedCount
 *
 * @property Treatment $lastestsubtreatment
 * @property Treatment[] $subtreatments
 * @property Treatment[] $subtreatmentswaiting
 */
trait SubTreatmentsManagement
{
    public function subtreatments() {
        return $this->hasMany(Treatment::class, 'uppertreatment_id');
    }
    public function lastestsubtreatment()
    {
        return $this->hasOne(Treatment::class, 'uppertreatment_id')->latest('id');
    }
    public function subtreatmentswaiting() {
        return $this->subtreatments()->waiting();
    }

    #region Accessors & Mutators
    public function getSubsWaitingAttribute() {
        return $this->subtreatments()->waiting()->get();
    }
    public function getSubsWaitingCountAttribute() {
        return $this->subtreatments()->waiting()->count();
    }
    public function getSubsQueuedCountAttribute() {
        return $this->subtreatments()->queued()->count();
    }
    public function getSubsRunningCountAttribute() {
        return $this->subtreatments()->running()->count();
    }
    public function getSubsRetryingCountAttribute() {
        return $this->subtreatments()->retrying()->count();
    }
    public function getSubsSuccessCountAttribute() {
        return $this->subtreatments()->success()->completed()->count();
    }
    public function getSubsFailedCountAttribute() {
        return $this->subtreatments()->failed()->waiting()->count();
    }
    #endregion

    #region Custom functions
    public function subTreatmentAlreadyExists(TreatmentCodeEnum $uppertreatment_code, int $exec_id) {

    }
    #endregion

    protected function initializeSubTreatmentsManagement()
    {
        $this->appends = array_unique(array_merge($this->appends, [
            'subsWaitingCount',
            'subsQueuedCount',
            'subsRunningCount',
            'subsRetryingCount',
            'subsSuccessCount',
            'subsFailedCount',
        ]));
    }
}
