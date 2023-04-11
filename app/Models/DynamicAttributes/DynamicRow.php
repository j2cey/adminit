<?php

namespace App\Models\DynamicAttributes;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\FormatRule\FormatRuleType;
use App\Traits\FormatRule\HasFormatRules;
use App\Contracts\FormatRule\IHasFormatRules;
use App\Traits\FormattedValue\HasFormattedValue;
use App\Contracts\FormattedValue\IHasFormattedValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
 * @method static DynamicRow create(array $array)
 */
class DynamicRow extends BaseModel implements Auditable, IHasFormattedValue, IHasFormatRules
{
    use HasFactory, HasFormattedValue, HasFormatRules, \OwenIt\Auditing\Auditable;

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
     * @param $line_num
     * @return Model|DynamicRow
     */
    public static function createNew($line_num): Model|DynamicRow
    {
        //$related_object->dynamicrows()->save($dynamicrow);
        //$dynamicrow->setFormattedValue(HtmlTagKey::TABLE_ROW);

        return DynamicRow::create([
            'line_num' => $line_num,
            'firstinserted_at' => Carbon::now(),
            'columns_values' => "[]",
        ]);
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
        // reset rawvalue from formatted values
        $this->resetRawValues();

        // get all dynamic values attached to this row
        $dynamicvalues = $this->dynamicvalues;

        foreach ($dynamicvalues as $dynamicvalue) {
            // apply formating (without rule) for each value
            $dynamicvalue->applyFormatFromFormatted($dynamicvalue->innerdynamicvalue->getValue(), $dynamicvalue->formatrules);
            // merge each row (this) formatted value with all dynamic values formatted values
            $this->mergeRawValueFromFormatted($dynamicvalue);
        }
        $this->applyFormatFromRaw(null, $this->formatrules);
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
