<?php

namespace App\Models\ReportTreatments\Treatment;

use App\Models\ReportTreatments\TreatmentResult;

/**
 * @property boolean $isSuccess
 * @property boolean $isFailed
 *
 */
trait ResultManagement
{
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
