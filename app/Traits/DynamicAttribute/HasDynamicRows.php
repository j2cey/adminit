<?php


namespace App\Traits\DynamicAttribute;

use App\Models\DynamicAttributes\DynamicRow;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property DynamicRow[] $dynamicrows
 * @property DynamicRow $latestDynamicrow
 * @property DynamicRow $oldestDynamicrow
 */
trait HasDynamicRows
{
    /**
     * Get all of the model's dynamic dynamicattributes
     * @return morphMany
     */
    public function dynamicrows()
    {
        return $this->morphMany(DynamicRow::class, 'hasdynamicrow');
    }

    /**
     * Get the lastets of the model's dynamic rows
     * @return morphOne
     */
    public function latestDynamicrow()
    {
        return $this->morphOne(DynamicRow::class, 'hasdynamicrow')->latest('id');
    }

    /**
     * Get the oldest of the model's dynamic rows
     * @return morphOne
     */
    public function oldestDynamicrow()
    {
        return $this->morphOne(DynamicRow::class, 'hasdynamicrow')->oldest('id');
    }
}
