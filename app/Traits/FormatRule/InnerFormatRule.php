<?php

namespace App\Traits\FormatRule;

use App\Models\FormatRule\FormatRule;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait InnerFormatRule
{
    use \OwenIt\Auditing\Auditable;

    public $format_value;

    #region Eloquent Relationships


    /**
     * @return morphOne
     */
    public function formatrule() {
        return $this->morphOne(FormatRule::class,"innerformatrule");
    }

    #endregion

    #region Custom Methods

    public function attachUpperFormatRule(FormatRule $upperformatrule) {
        $this->formatrule()->save($upperformatrule);
    }

    #endregion

    /**
     * Add, dynamically, Eloquent relation (eager loading) to this model
     */
    protected function initializeInnerFormatRule()
    {
        //$this->with = array_unique(array_merge($this->with, ['formatrule']));
    }

    public static function bootInnerFormatRule()
    {
        static::deleting(function ($model) {

        });
    }
}
