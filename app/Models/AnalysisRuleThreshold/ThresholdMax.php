<?php

namespace App\Models\AnalysisRuleThreshold;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\Threshold\InnerThreshold;
use App\Contracts\AnalysisRules\IInnerThreshold;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ThresholdMax
 * @package App\Models\Threshold
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property int $threshold
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ThresholdMax extends BaseModel implements IInnerThreshold
{
    use HasFactory, InnerThreshold;

    #region Validation Rules

    public static function defaultRules() {
        return [
            'threshold' => ['required'],
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

    #endregion

    #region Custom Functions

    public static function createNew(): ThresholdMax
    {
        return ThresholdMax::create();
    }
}
