<?php

namespace App\Models\AnalysisRuleThreshold;

use App\Models\BaseModel;
use App\Enums\RuleResultEnum;
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

    protected $guarded = [];

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

    public static function createNew(array $attributes = []): ThresholdMax
    {
        if ( empty($attributes) ) {
            return ThresholdMax::create();
        } else {
            $data = [];
            if (array_key_exists("threshold", $attributes)) {
                $data['threshold'] = $attributes['threshold'];
            }
            if (array_key_exists("comment", $attributes)) {
                $data['comment'] = $attributes['comment'];
            }
            return ThresholdMax::create($data);
        }
    }

    public function updateOne(array $attributes = []) : ThresholdMax
    {
        if ( ! empty($attributes) ) {

            $this->threshold = array_key_exists("threshold", $attributes) ? $attributes['threshold'] : $this->threshold;
            $this->comment = array_key_exists("comment", $attributes) ? $attributes['comment'] : $this->comment;

            $this->save();
        }

        return $this;
    }

    public function applyRule($input): RuleResultEnum
    {
        return ($input < $this->threshold) ? RuleResultEnum::ALLOWED : RuleResultEnum::BROKEN;
    }
}
