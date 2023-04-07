<?php

namespace App\Models\DynamicAttributes;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FormattedValue\HasFormattedValues;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Contracts\FormattedValue\IHasFormattedValues;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\DynamicAttribute\IInnerDynamicValue;

/**
 * Class DynamicValue
 * @package App\Models\DynamicAttributes
 *
 * @property integer $id
 *
 * @property integer $dynamic_row_id
 * @property integer $dynamic_attribute_id
 *
 * @property string $innerdynamicvalue_type
 * @property integer $innerdynamicvalue_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property IInnerDynamicValue $innerdynamicvalue
 * @property DynamicRow $dynamicrow
 * @property DynamicAttribute $dynamicattribute
 * @method static DynamicValue create(array $array)
 */
class DynamicValue extends Model implements IHasFormattedValues
{
    use HasFactory, HasFormattedValues;

    protected $guarded = [];
    protected $with = ['innerdynamicvalue'];

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

    public function dynamicrow() {
        return $this->belongsTo(DynamicRow::class,"dynamic_row_id");
    }

    public function dynamicattribute() {
        return $this->belongsTo(DynamicAttribute::class,"dynamic_attribute_id");
    }

    /**
     * @return MorphTo
     */
    public function innerdynamicvalue()
    {
        return $this->morphTo();
    }

    #endregion

    #region Custom Functions

    /*public static function createInnerDynamicValue( $thevalue, DynamicAttribute $dynamicattributes, DynamicRow $row ) : IInnerDynamicValue {
        //
    }*/

    /**
     * @param $thevalue
     * @param DynamicAttribute $dynamicattribute
     * @param DynamicRow $row
     * @return DynamicValue
     */
    public static function createNew($thevalue, DynamicAttribute $dynamicattribute, DynamicRow $row) {
        return $dynamicattribute
            ->dynamicattributetype->model_type::createNew($thevalue,$dynamicattribute,$row)
            ->dynamicvalue;
    }

    #endregion

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $model->innerdynamicvalue->delete();
        });
    }
}
