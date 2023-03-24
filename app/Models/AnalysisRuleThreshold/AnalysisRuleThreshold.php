<?php

namespace App\Models\AnalysisRuleThreshold;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\AnalysisRules\IsInnerRule;
use App\Contracts\AnalysisRules\IInnerRule;
use App\Contracts\AnalysisRules\IInnerThreshold;
use Illuminate\Database\Eloquent\Relations\MorphTo;
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
 * @property string|null $innerthreshold_type
 * @property int|null $innerthreshold_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property IInnerThreshold $innerthreshold
 * @property ThresholdType $thresholdtype
 */
class AnalysisRuleThreshold extends BaseModel implements IInnerRule
{
    use IsInnerRule, HasFactory;

    protected $guarded = [];
    protected $with = ['thresholdtype','status'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'threshold' => ['required','numeric'],
            'innerthreshold' => ['required'],
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
            'threshold.required' => "Prière de renseigner le Seuil",
            'innerthreshold.required' => "Prière de renseigner le Type",
        ];

    }

    #endregion

    #region Eloquent Relationships

    public function thresholdtype() {
        return $this->belongsTo(ThresholdType::class,"threshold_type_id");
    }

    /**
     * @return MorphTo|IInnerThreshold
     * Get the parent inner highlight model.
     */
    public function innerthreshold()
    {
        return $this->morphTo();
    }

    #endregion

    #region Custom Functions

    public static function createInnerThreshold(ThresholdType $thresholdtype) : IInnerThreshold {
        return $thresholdtype->inner_threshold_class::createNew();
    }

    private function syncInnerThreshold(ThresholdType $thresholdtype, IInnerThreshold $innerthreshold) : IInnerThreshold {

        if ( $this->thresholdtype->id !== $thresholdtype->id ) {
            // remove the old innerthreshold
            $this->removeInnerThreshold();

            // and we have to create a new one from new type
            $innerthreshold = $this->createInnerThreshold($thresholdtype);

            $innerthreshold->attachUpperThreshold($this);
            $this->thresholdtype()->associate($thresholdtype);

            $this->save();
        }

        return $innerthreshold;
    }

    public function removeInnerThreshold()
    {
        $this->innerthreshold->delete();
    }

    public static function createNew(): AnalysisRuleThreshold {

        $default_treshold_type = ThresholdType::getDefault();
        $innerthreshold = self::createInnerThreshold($default_treshold_type);

        $innerrule = $innerthreshold->analysisrulethreshold()->create();

        $innerrule->save();

        return $innerrule;
    }

    public function updateOne(ThresholdType $thresholdtype, $threshold, $comment) : AnalysisRuleThreshold
    {
        $this->syncInnerThreshold($thresholdtype, $this->innerthreshold);

        $this->threshold = $threshold;
        $this->comment = $comment;

        $this->save();

        return $this;
    }

    #endregion

    public function ruleFollowed($input): bool
    {
        //return $this->thresholdtype->code == "min" ? ($input >= $this->threshold) : ($input <= $this->threshold);
        if ($this->thresholdtype->code == "min") {
            return ($input >= $this->threshold);
        } else {
            return ($input <= $this->threshold);
        }
    }

    public function ruleBroken($input): bool
    {
        return $this->thresholdtype->code == "min" ? ($input <= $this->threshold) : ($input >= $this->threshold);
    }
}
