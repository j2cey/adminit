<?php

namespace App\Traits\FormattedValue;

use App\Models\FormattedValue\FormattedValue;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait InnerFormattedValue
{
    use \OwenIt\Auditing\Auditable;

    public string $thevalue;

    #region Eloquent Relationships


    /**
     * @return morphOne
     */
    public function formattedvalue() {
        return $this->morphOne(FormattedValue::class,"innerformattedvalue");
    }

    #endregion

    #region Custom Methods

    public function attachUpperFormattedValue(FormattedValue $upperformattedvalue) {
        $this->formattedvalue()->save($upperformattedvalue);
    }

    #endregion

    /**
     * Add, dynamically, Eloquent relation (eager loading) to this model
     */
    protected function initializeInnerFormattedValue()
    {
        //$this->with = array_unique(array_merge($this->with, ['formattedvalue']));
    }

    public static function bootInnerFormattedValue()
    {
        static::deleting(function ($model) {

        });
    }
}
