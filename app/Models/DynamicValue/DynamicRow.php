<?php

namespace App\Models\DynamicValue;

use App\Models\BaseModel;
use App\Enums\HtmlTagKey;
use Illuminate\Support\Carbon;
use App\Models\Import\IsImportable;
use App\Models\Format\IsFormattable;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Import\IIsImportable;
use OwenIt\Auditing\Contracts\Auditable;
use App\Contracts\Format\IIsFormattable;
use App\Traits\FormatRule\HasFormatRules;
use Illuminate\Database\Eloquent\Builder;
use App\Contracts\FormatRule\IHasFormatRules;
use App\Traits\FormattedValue\HasFormattedValue;
use App\Traits\DynamicAttribute\HasDynamicValues;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Contracts\DynamicAttribute\IHasDynamicRows;
use App\Contracts\FormattedValue\IHasFormattedValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\AnalysisRules\IHasMatchedAnalysisRules;
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
 * @property string $columns_values
 * @property string $raw_value
 *
 * @property bool $is_imported
 * @property bool $is_formatted
 * @property bool $is_merged
 * @property bool $is_next_to_merge
 *
 * @property string|null $hasdynamicattributes_class
 * @property int|null $hasdynamicattributes_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property DynamicValue[] $dynamicvalues
 * @property IHasDynamicRows|IHasMatchedAnalysisRules $hasdynamicrow
 * @method static DynamicRow create(array $array)
 *
 * @method static Builder formatted()
 */
class DynamicRow extends BaseModel implements Auditable, IHasFormattedValue, IHasFormatRules, IIsImportable, IIsFormattable
{
    use HasFactory, HasDynamicValues, HasFormattedValue, HasFormatRules, IsImportable, IsFormattable, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['dynamicvalues'];
    protected $casts = [
        //'columns_values' => 'array',
        //'raw_value' => 'array'
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

    #region Scopes

    public function scopeFormatted($query) {
        return $query->where('is_formatted', 1);
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
     * @param array|null $raw_value
     * @return Model|DynamicRow
     */
    public static function createNew($line_num, array $raw_value = null): Model|DynamicRow
    {
        //$related_object->dynamicrows()->save($dynamicrow);
        //$dynamicrow->setFormattedValue(HtmlTagKey::TABLE_ROW);

        return DynamicRow::create([
            'line_num' => $line_num,
            'firstinserted_at' => Carbon::now(),
            'columns_values' => "[]",
            'raw_value' => is_null($raw_value) ? "[]" : json_encode($raw_value),
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

    public function isValueEqual(DynamicAttribute $dynamicattribute, mixed $attribute_value): bool {
        $result = false;
        $dynamicvalues = $this->dynamicvalues;
        foreach ($dynamicvalues as $dynamicvalue) {
            if ( $dynamicvalue->dynamicattribute->id === $dynamicattribute->id ) {
                $result = $dynamicvalue->isValueEqual($attribute_value);
            }
        }
        return $result;
    }

    public function getDynamicValue(DynamicAttribute $dynamicattribute): ?DynamicValue {
        $dynamicvalues = $this->dynamicvalues;
        foreach ($dynamicvalues as $dynamicvalue) {
            if ( $dynamicvalue->dynamicattribute->id === $dynamicattribute->id ) {
                return $dynamicvalue;
            }
        }
        return null;
    }

    public function mergeColumnsValues() {
        $this->columns_values = [];
        $merged_values = [];
        $dynamicvalues = $this->dynamicvalues;

        foreach ($dynamicvalues as $dynamicvalue) {
            $new_arr = [ $dynamicvalue->dynamicattribute->name => $dynamicvalue->innerdynamicvalue->getValue() ];
            $merged_values = array_merge($new_arr, $merged_values);
        }
        $this->columns_values = array_merge( $merged_values, $this->columns_values );
        $this->save();

        return $merged_values;
    }

    /**
     * @param int $id
     * @return DynamicRow|null
     */
    public static function getById(int $id) {
        return DynamicRow::find($id);
    }

    /**
     * @return null|IHasDynamicAttributes
     */
    public function getHasdynamicattributes(): ?IHasDynamicAttributes
    {
        if ( is_null($this->hasdynamicattributes_class) || is_null($this->hasdynamicattributes_id) ) {
            return null;
        }
        return $this->hasdynamicattributes_class::where('id', $this->hasdynamicattributes_id)->first();
    }

    #endregion

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {

        });

        self::deleting(function ($model) {
            $model->dynamicvalues()->each(function($dynamicvalue) {
                $dynamicvalue->delete(); // <-- direct deletion
            });
            $model->columns_values = "[]";
        });
    }

    public function getHtmlTagKey(): HtmlTagKey
    {
        return HtmlTagKey::TABLE_ROW;
    }

    public function getImportedSuccessRate(): float
    {
        return 100;
    }
    public function getUpperIsImportable(): ?IIsImportable
    {
        return $this->hasdynamicrow;
    }

    public function getFormattedSuccessRate(): float
    {
        return 100;
    }
    public function getUpperIsFormattable(): ?IIsFormattable
    {
        return $this->hasdynamicrow;
    }
}
