<?php


namespace App\Traits\AnalysisRules;

use App\Models\AnalysisRules\AnalysisRule;

trait IsInnerRule
{
    use \OwenIt\Auditing\Auditable;

    #region Eloquent Relationships

    public function analysisrule() {
        return $this->morphOne(AnalysisRule::class,"innerrule");
    }

    #endregion

    #region Custom Methods

    public function attachUpperRule(AnalysisRule $upperrule) {
        $this->analysisrule()->save($upperrule);
    }

    #endregion

    protected function initializeIsInnerRule()
    {
       // $this->with = array_unique(array_merge($this->with, ['analysisrule']));
    }

    public static function bootIsInnerRule()
    {
        static::deleting(function ($model) {

        });
    }
}
