<?php

namespace App\Traits\ReportTreatment;

use App\Models\DynamicValue\DynamicRow;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $dynamic_row_id
 *
 * @property DynamicRow $dynamicrow
 */
trait HasDynamicRow
{
    public function dynamicrow(): BelongsTo
    {
        return $this->belongsTo(DynamicRow::class, 'dynamic_row_id');
    }

    public function setDynamicRow(DynamicRow $dynamicrow = null): static
    {
        if ( ! is_null($dynamicrow) ) {
            $this->dynamicrow()->associate($dynamicrow);
            $this->save();
        }

        return $this;
    }

    protected function initializeHasDynamicRow()
    {
        $this->with = array_unique(array_merge($this->with, ['dynamicrow']));
    }

    protected static function bootHasDynamicRow()
    {
        $class = static::class;
        $method = "initializeHasDynamicRow";

        static::$traitInitializers[$class][] = $method;

        static::$traitInitializers[$class] = array_unique(
            static::$traitInitializers[$class]
        );
    }
}
