<?php

namespace App\Contracts\DynamicAttribute;

use Illuminate\Database\Eloquent\Model;
use App\Models\DynamicValue\DynamicRow;
use App\Contracts\Import\IIsImportable;
use App\Contracts\Format\IIsFormattable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface IHasDynamicRows extends IIsImportable, IIsFormattable
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

    public function addRow(IHasDynamicAttributes $hasdynamicattributes, array $raw_value = null): Model|DynamicRow;
    public function deleteRows();

    public function setRowsImported(bool $new_row_imported);
}
