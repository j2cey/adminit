<?php

namespace App\Models\AnalysisRules;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\AnalysisRules\IsInnerRule;
use App\Contracts\AnalysisRules\IInnerRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AnalysisRuleThreshold
 * @package App\Models\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer $threshold
 * @property integer|null $threshold_type_id
 *
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AnalysisRuleThreshold extends BaseModel  implements IInnerRule
{
    use IsInnerRule, HasFactory;

    protected $guarded = [];
    protected $with = ['thresholdtype','status'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'threshold' => ['required','numeric'],
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

    public function thresholdtype() {
        return $this->belongsTo(ThresholdType::class,"threshold_type_id");
    }

    #endregion

    #region Custom Functions

    public static function createNew(): AnalysisRuleThreshold {

        $default_treshold_type = ThresholdType::getDefault();

        $innerrule = AnalysisRuleThreshold::create();

        $innerrule->thresholdtype()->associate($default_treshold_type)->save();

        return $innerrule;
    }

    #endregion

    public function ruleFollowed($input): bool
    {
        return $this->thresholdtype->code == "min" ? ($input >= $this->threshold) : ($input <= $this->threshold);
    }

    public function ruleBroken($input): bool
    {
        return $this->thresholdtype->code == "min" ? ($input <= $this->threshold) : ($input >= $this->threshold);
    }
}
