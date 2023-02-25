<?php

namespace App\Models\DynamicAttributes;


use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DynamicAttribute\HasDynamicValues;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class DynamicValueInteger
 * @package App\Models\DynamicAttributes
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer $thevalue
 * @property integer $dynamic_row_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class DynamicValueInteger extends Model
{
    use HasDynamicValues, HasFactory;

    protected $guarded = [];

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

    public function getFormattedValue($thevalue)
    {
        return intval($thevalue);
    }

    #endregion
}
