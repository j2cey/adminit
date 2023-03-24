<?php

namespace App\Traits\Comparison;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\AnalysisRuleComparison\AnalysisRuleComparison;

trait InnerComparison
{
    use \OwenIt\Auditing\Auditable;

    #region Eloquent Relationships

    /**
     * @return morphOne
     */
    public function analysisrulecomparison() {
        return $this->morphOne(AnalysisRuleComparison::class,"innercomparison");
    }

    #endregion

    #region Custom Methods

    public function attachUpperComparison(AnalysisRuleComparison $uppercomparison) {
        $this->analysisrulecomparison()->save($uppercomparison);
    }

    #endregion

    /**
     * Add, dynamically, Eloquent relation (eager loading) to this model
     */
    protected function initializeInnerComparison()
    {
        //$this->with = array_unique(array_merge($this->with, ['analysisrulecomparison']));
    }

    public static function bootInnerComparison()
    {
        static::deleting(function ($model) {

        });
    }
}
