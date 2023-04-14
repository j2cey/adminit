<?php

namespace App\Contracts\DynamicAttribute;

use Illuminate\Database\Eloquent\Model;
use App\Models\DynamicValue\DynamicRow;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface IHasDynamicRows
{
    /**
     * Get all of the model's dynamic dynamicattributes
     * @return morphMany
     */
    public function dynamicrows();

    /**
     * Get the lastets of the model's dynamic rows
     * @return morphOne
     */
    public function latestDynamicrow();

    /**
     * Get the oldest of the model's dynamic rows
     * @return morphOne
     */
    public function oldestDynamicrow();

    public function addRow(): Model|DynamicRow;
    public function deleteRows();
}
