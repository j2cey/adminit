<?php

namespace App\Traits\Threshold;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\AnalysisRuleThreshold\AnalysisRuleThreshold;

trait InnerThreshold
{
    use \OwenIt\Auditing\Auditable;

    public $threshold_value;

    #region Eloquent Relationships


    /**
     * @return morphOne
     */
    public function analysisrulethreshold() {
        return $this->morphOne(AnalysisRuleThreshold::class,"innerthreshold");
    }

    #endregion

    #region Custom Methods

    public function attachUpperThreshold(AnalysisRuleThreshold $upperthreshold) {
        $this->analysisrulethreshold()->save($upperthreshold);
    }

    #endregion

    /**
     * Add, dynamically, Eloquent relation (eager loading) to this model
     */
    protected function initializeInnerThreshold()
    {
        //$this->with = array_unique(array_merge($this->with, ['analysisrulethreshold']));
    }

    public static function bootInnerThreshold()
    {
        static::deleting(function ($model) {

        });
    }
}
