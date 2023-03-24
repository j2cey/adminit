<?php


namespace App\Traits\AnalysisRules;

use App\Models\AnalysisHighlight\AnalysisHighlight;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait IsInnerHighlight
{
    use \OwenIt\Auditing\Auditable;

    public $highlight_value;

    #region Eloquent Relationships


    /**
     * @return morphOne
     */
    public function analysishighlight() {
        return $this->morphOne(AnalysisHighlight::class,"innerhighlight");
    }

    #endregion

    #region Custom Methods

    public function attachUpperHighlight(AnalysisHighlight $upperhighlight) {
        $this->analysishighlight()->save($upperhighlight);
    }

    #endregion

    /**
     * Add, dynamically, Eloquent relation (eager loading) to this model
     */
    protected function initializeIsInnerHighlight()
    {
        //$this->with = array_unique(array_merge($this->with, ['analysishighlight']));
    }

    public static function bootIsInnerHighlight()
    {
        static::deleting(function ($model) {

        });
    }
}
