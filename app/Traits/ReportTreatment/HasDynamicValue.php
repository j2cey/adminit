<?php

namespace App\Traits\ReportTreatment;

use App\Models\DynamicValue\DynamicValue;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $dynamic_value_id
 *
 * @property DynamicValue $dynamicvalue
 */
trait HasDynamicValue
{
    public function dynamicvalue(): BelongsTo
    {
        return $this->belongsTo(DynamicValue::class, 'dynamic_value_id');
    }

    public function setDynamicValue(DynamicValue $dynamicvalue = null): static
    {
        if ( ! is_null($dynamicvalue) ) {
            $this->dynamicvalue()->associate($dynamicvalue);
            $this->save();
        }

        return $this;
    }
}
