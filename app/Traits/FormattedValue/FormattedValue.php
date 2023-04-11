<?php

namespace App\Traits\FormattedValue;

use Illuminate\Database\Eloquent\Relations\MorphTo;

trait FormattedValue
{
    use \OwenIt\Auditing\Auditable;

    public string $thevalue;

    #region Eloquent Relationships


    /**
     * The Formatted value owner
     * @return MorphTo
     */
    public function hasformattedvalue()
    {
        return $this->morphTo();
    }

    #endregion

    /**
     * Add, dynamically, Eloquent relation (eager loading) to this model
     */
    protected function initializeFormattedValue()
    {
        //$this->with = array_unique(array_merge($this->with, ['formattedvalue']));
    }

    public static function bootFormattedValue()
    {
        static::deleting(function ($model) {

        });
    }
}
