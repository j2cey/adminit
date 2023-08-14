<?php


namespace App\Traits\DynamicAttribute;

use App\Enums\HtmlTagKey;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\DynamicValue\DynamicRow;
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

    /**
     * @return Model|DynamicRow
     */
    public function addRow(array $raw_value = null): Model|DynamicRow
    {
        //$dynamicrow = DynamicRow::createNew($this->dynamicrows()->count() + 1);
        $line_num = $this->dynamicrows()->count() + 1;

        $dynamicrow = $this->dynamicrows()->create([
            'line_num' => $line_num,
            'firstinserted_at' => Carbon::now(),
            'columns_values' => "[]",
            'raw_value' => is_null($raw_value) ? "[]" : json_encode($raw_value),
        ]);

        $dynamicrow->setFormattedValue(HtmlTagKey::TABLE_ROW);
        $dynamicrow->setDefaultFormatSize();

        return $dynamicrow;
    }

    public function deleteRows()
    {
        $this->dynamicrows()->each(function ($row) {
            $row->delete(); // <-- direct deletion
        });
    }

    protected function initializeHasDynamicRows()
    {
        $this->with = array_unique(array_merge($this->with, ['dynamicrows']));
    }

    public static function bootHasDynamicRows()
    {
        static::deleting(function ($model) {
            $model->deleteRows();
        });
    }
}
