<?php

namespace App\Models\DynamicAttributes;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class DynamicValue
 * @package App\Models\DynamicAttributes
 *
 * @property integer $id
 *
 * @property integer $dynamic_row_id
 * @property string $hasdynamicvalue_type
 * @property integer $hasdynamicvalue_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class DynamicValue extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['hasdynamicvalue'];

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'thevalue' => ['required'],
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function updateRules($model)
    {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function messagesRules()
    {
        return [

        ];
    }

    #endregion

    #region Eloquent Relationships

    public function valuerow() {
        return $this->belongsTo(DynamicRow::class,"dynamic_row_id");
    }

    public function hasdynamicvalue()
    {
        return $this->morphTo();
    }

    #endregion

    #region Custom Functions

    /*public static function createNew($thevalue, DynamicAttribute $dynamicattribute, DynamicRow $row) {
        $dynamicvalue = DynamicValue::create([
            'dynamic_row_id' => $row->id,
        ]);
        return $dynamicvalue;
    }*/

    #endregion
}
