<?php


namespace App\Traits\DynamicAttribute;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\DynamicValue\DynamicRow;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Contracts\DynamicAttribute\IHasDynamicAttributes;

/**
 * @property DynamicRow[] $dynamicrows
 * @property DynamicRow $latestDynamicrow
 * @property DynamicRow $oldestDynamicrow
 */
trait HasDynamicRows
{
    /**
     * Give the ability to merge the new dynamic's raw value to upper table
     * @param array|null $raw_value
     * @return void
     */
    public abstract function mergeRawValueFromRow(array $raw_value = null);

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
     * @param IHasDynamicAttributes $hasdynamicattributes
     * @param array|null $raw_value
     * @return Model|DynamicRow
     */
    public function addRow(IHasDynamicAttributes $hasdynamicattributes, array $raw_value = null): Model|DynamicRow
    {
        //\Log::info("HasDynamicRows - addRow, hasdynamicattributes: " . $hasdynamicattributes->id);
        //$dynamicrow = DynamicRow::createNew($this->dynamicrows()->count() + 1);
        $line_num = $this->dynamicrows()->count() + 1;

        $dynamicrow = $this->createNewRow($line_num, $raw_value, get_class($hasdynamicattributes), $hasdynamicattributes->id);

        return $dynamicrow;
    }

    /**
     * @param int $line_num
     * @param array|null $raw_value
     * @param string|null $hasdynamicattributes_class
     * @param int|null $hasdynamicattributes_id
     * @return Model|DynamicRow
     */
    private function createNewRow(int $line_num, array|null $raw_value, string|null $hasdynamicattributes_class, int|null $hasdynamicattributes_id): DynamicRow|Model
    {
        return $this->dynamicrows()->create([
            'line_num' => $line_num,
            'firstinserted_at' => Carbon::now(),
            'columns_values' => is_null($raw_value) ? "[]" : json_encode($raw_value),
            'raw_value' => is_null($raw_value) ? "[]" : json_encode($raw_value),
            'hasdynamicattributes_class' => is_null($hasdynamicattributes_class) ? null : $hasdynamicattributes_class,
            'hasdynamicattributes_id' => is_null($hasdynamicattributes_id) ? null : $hasdynamicattributes_id,
        ]);
    }

    public function deleteRows()
    {
        $this->dynamicrows()->each(function ($row) {
            $row->delete(); // <-- direct deletion
        });
    }

    public function setRowsImported(bool $new_row_imported) {
        if ( $new_row_imported ) {
            $this->setNewRowImported();
        }
    }

    private function setNewRowImported() {
        $this->nb_rows_import_processed++;
        $this->nb_rows_import_success++;

        $this->imported = ($this->nb_rows_import_processed > 0 && ( $this->nb_rows_import_success >= $this->nb_rows_import_processed ));
        $this->save();
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
