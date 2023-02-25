<?php

namespace App\Models\AnalysisRules;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ThresholdType
 * @package App\Models\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $label
 * @property string $code
 *
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ThresholdType extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'label' => ['required'],
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

    public static function createNew($label, $code,$description): ThresholdType {

        return ThresholdType::create([
            'label' => $label,
            'code' => $code,
            'description' => $description,
        ]);
    }

    // Analysis Rule broken

    // Analysis Rule followed

    #endregion
}
