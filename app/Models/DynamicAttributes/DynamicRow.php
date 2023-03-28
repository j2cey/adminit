<?php

namespace App\Models\DynamicAttributes;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
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
 * @property string $columns_values
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class DynamicRow extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['dynamicvalues'];
    protected $casts = [
        //'columns_values' => 'array'
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

    public static function createNew($related_object) {
        /*$line_num = DynamicRow::where('hasdynamicrow_type',$dynamicattribute->hasdynamicattribute_type)
                ->where('hasdynamicrow_id', $dynamicattribute->hasdynamicattribute_id)->count() + 1;
        return DynamicRow::create([
            'line_num' => $line_num,
            'firstinserted_at' => Carbon::now(),
            'hasdynamicrow_type' => $dynamicattribute->hasdynamicattribute_type,
            'hasdynamicrow_id' => $dynamicattribute->hasdynamicattribute_id,
        ]);*/
        $line_num = $related_object->dynamicrows()->count() + 1;
        return $related_object->dynamicrows()->create([
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

    public function addColumnValue($column_name, $thevalue) {
        $columns_values_arr = (array) json_decode( $this->columns_values, true );
        $columns_values_arr = array_merge($columns_values_arr, [$column_name => $thevalue]);
        //$new_column_value_arr = [$column_name => $thevalue];
        //$new_columns_values_arr = $columns_values_arr + $new_column_value_arr;

        $this->columns_values = json_encode( $columns_values_arr );

        $this->save();
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
