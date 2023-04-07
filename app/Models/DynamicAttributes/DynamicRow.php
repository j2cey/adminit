<?php

namespace App\Models\DynamicAttributes;

use App\Models\BaseModel;
use App\Enums\HtmlTagKey;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\FormattedValue\HasFormattedValues;
use App\Contracts\DynamicAttribute\IHasDynamicRows;
use App\Contracts\FormattedValue\IHasFormattedValues;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\DynamicAttribute\IHasDynamicAttributes;

/**
 * Class DynamicRow
 * @package App\Models\DynamicAttributes
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $line_uuid
 * @property integer $line_num
 *
 * @property Carbon $firstinserted_at
 * @property Carbon $lastinserted_at
 *
 * @property string $hasdynamicrow_type
 * @property integer $hasdynamicrow_id
 *
 * @property array $columns_values
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property DynamicValue[] $dynamicvalues
 */
class DynamicRow extends BaseModel implements Auditable, IHasFormattedValues
{
    use HasFactory, HasFormattedValues, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['dynamicvalues'];
    protected $casts = [
        'columns_values' => 'array'
    ];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'line_uuid' => ['required'],
            'line_num' => ['required'],
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function messagesRules() {
        return [

        ];
    }

    #endregion

    #region Eloquent Relationships

    public function hasdynamicrow()
    {
        return $this->morphTo();
    }

    public function dynamicvalues() {
        return $this->hasMany(DynamicValue::class, "dynamic_row_id");
    }

    #endregion

    #region Custom Functions

    /**
     * @param IHasDynamicRows $related_object
     * @return Model|DynamicRow
     */
    public static function createNew(IHasDynamicRows $related_object) {
        $line_num = $related_object->dynamicrows()->count() + 1;
        $dynamicrow = $related_object->dynamicrows()->create([
            'line_num' => $line_num,
            'firstinserted_at' => Carbon::now(),
            'columns_values' => "[]",
        ]);
        $dynamicrow->setFormattedValues(HtmlTagKey::TABLE_ROW);

        return $dynamicrow;
    }

    /**
     * Set the last inserted date
     * @param null $newdate
     */
    public function setLastInserted($newdate = null) {
        $finaldate = $newdate ?? Carbon::now();
        $this->update([
            'lastinserted_at' => $finaldate,
        ]);
    }

    public function mergeColumnsValues() {
        $this->columns_values = [];
        $merged_values = [];
        $dynamicvalues = $this->dynamicvalues;

        foreach ($dynamicvalues as $dynamicValue) {
            $new_arr = [ $dynamicValue->dynamicattribute->name => $dynamicValue->innerdynamicvalue->getValue() ];
            $merged_values = array_merge($new_arr, $merged_values);
        }
        $this->columns_values = array_merge( $merged_values, $this->columns_values );
        $this->save();

        return $merged_values;
    }

    public function mergeColumnsFormattedValues() {
        // get all dynamic values attached to this row
        $dynamicvalues = $this->dynamicvalues;

        foreach ($dynamicvalues as $dynamicvalue) {
            // apply formating (without rule) for each value
            $dynamicvalue->applyFormat($dynamicvalue->innerdynamicvalue->getValue());
            foreach ($this->formattedvalues as $formattedvalue) {
                foreach ($dynamicvalue->formattedvalues as $dynamicvalue_formatted) {
                    // merge each row (this) formatted value with all dynamic values formatted values
                    $formattedvalue->mergeRawValue($dynamicvalue_formatted, $dynamicvalue_formatted->innerformattedvalue->getFormattedValue());
                }
            }
        }
        $this->applyFormat();
    }

    #endregion

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $model->dynamicvalues()->each(function($dynamicvalue) {
                $dynamicvalue->delete(); // <-- direct deletion
            });
            $model->columns_values = "[]";
        });
    }
}
