<?php

namespace App\Models\Treatments\Treatment;

use Illuminate\Database\Query\Builder;
use App\Models\Treatments\TreatmentResult;
use App\Enums\Treatments\TreatmentResultEnum;

/**
 * @property boolean $isSuccess
 * @property boolean $isFailed
 *
 * @method static Builder success()
 * @method static Builder notFailed()
 * @method static Builder failed()
 */
trait ResultManagement
{
    #region scopes

    public function scopeSuccess($query){
        return $query->whereHas('treatmentresult', function($q){
            $q->where('result', TreatmentResultEnum::SUCCESS->value);
        });
    }

    public function scopeNotFailed($query) {
        return $query->whereHas('treatmentresult', function($q){
            $q->whereNotIn('result', [TreatmentResultEnum::FAILED->value]);
        });
    }

    public function scopeFailed($query) {
        return $query->whereHas('treatmentresult', function($q){
            $q->where('result', TreatmentResultEnum::FAILED->value);
        });
    }

    #endregion

    public function getIsSuccessAttribute() {
        return  $this->treatmentresult->isSuccess;
    }

    public function getIsFailedAttribute() {
        return  $this->treatmentresult->isFailed;
    }

    public function treatmentresult() {
        return $this->belongsTo(TreatmentResult::class, 'current_result_id');
    }
    public function treatmentresults() {
        return $this->hasMany(TreatmentResult::class, 'treatment_id');
    }

    public function addResult() {
        $results_count = $this->treatmentresults()->count();
        $result = TreatmentResult::createNew($this, $results_count + 1);

        // set as current result
        $this->treatmentresult()->associate($result)->save();

        // set result treatment for history
        $result->treatment()->associate($this)->save();
    }
}
