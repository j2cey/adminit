<?php

namespace App\Models\DynamicValue;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\FormatRule\HasFormatRules;
use App\Contracts\FormatRule\IHasFormatRules;
use App\Traits\FormattedValue\HasFormattedValue;
use App\Models\DynamicAttributes\DynamicAttribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Contracts\FormattedValue\IHasFormattedValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\DynamicAttribute\IInnerDynamicValue;
use App\Contracts\AnalysisRules\IHasMatchedAnalysisRules;

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
class DynamicValue extends Model implements Auditable, IHasFormattedValue, IHasFormatRules
{
    use HasFactory, HasFormattedValue, HasFormatRules, \OwenIt\Auditing\Auditable;

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

    public function getValue() {
        return $this->innerdynamicvalue->getValue();
    }

    public function getFormatRulesForNotification(IHasMatchedAnalysisRules $ihasmatchedanalysisrules) {
        return $this->dynamicattribute->getFormatRulesForNotification($this, $ihasmatchedanalysisrules);
    }

    public function isValueEqual(mixed $attribute_value): bool {
        return $this->getValue() === $attribute_value;
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
