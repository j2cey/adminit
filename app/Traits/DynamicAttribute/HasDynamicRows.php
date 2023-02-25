<?php


namespace App\Traits\DynamicAttribute;

use App\Models\DynamicAttributes\DynamicRow;

trait HasDynamicRows
{
    /**
     * Get all of the model's dynamic attributes
     * @return mixed
     */
    public function dynamicrows()
    {
        return $this->morphMany(DynamicRow::class, 'hasdynamicrow');
    }

    /**
     * Get the lastets of the model's dynamic rows
     * @return mixed
     */
    public function latestDynamicrow()
    {
        return $this->morphOne(DynamicRow::class, 'hasdynamicrow')->latest('id');
    }

    /**
     * Get the oldest of the model's dynamic rows
     * @return mixed
     */
    public function oldestDynamicrow()
    {
        return $this->morphOne(DynamicRow::class, 'hasdynamicrow')->oldest('id');
    }
}
