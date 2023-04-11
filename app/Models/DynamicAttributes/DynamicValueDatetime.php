<?php

namespace App\Models\DynamicAttributes;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DynamicAttribute\InnerDynamicValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\DynamicAttribute\IInnerDynamicValue;

/**
 * Class DynamicValueDatetime
 * @package App\Models\DynamicAttributes
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property Carbon $thevalue
 * @property integer $dynamic_row_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class DynamicValueDatetime extends Model implements IInnerDynamicValue
{
    use InnerDynamicValue, HasFactory;

    protected $guarded = [];
    protected $casts = [
        'thevalue' => 'datetime:Y-m-d H:i:s',
    ];

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



    #endregion

    #region Custom Functions

    public static function getFormattedValue($thevalue)
    {
        return empty($thevalue) ? new \DateTime() : $thevalue;
    }

    public function getValue() {
        $thevalue_arr = $this->thevalue->toArray();
        return $thevalue_arr['day'] .
            "-" . $thevalue_arr['month'] .
            "-" . substr($thevalue_arr['year'], -2) . " " .
            $thevalue_arr['hour'] .
            ":" . $thevalue_arr['minute'] .
            ":" . $thevalue_arr['second'];
    }

    #endregion
}
