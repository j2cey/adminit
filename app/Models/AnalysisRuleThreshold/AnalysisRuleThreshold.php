<?php

namespace App\Models\AnalysisRuleThreshold;

use App\Models\BaseModel;
use App\Enums\RuleResultEnum;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AnalysisRules\InnerAnalysisRule;
use App\Contracts\AnalysisRules\IInnerThreshold;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Contracts\AnalysisRules\IInnerAnalysisRule;
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
class AnalysisRuleThreshold extends BaseModel implements IInnerAnalysisRule
{
    use InnerAnalysisRule, HasFactory;

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
        //$this->update();
        return $this->morphTo();
    }

    #endregion

    #region Custom Functions

    public static function createInnerThreshold(ThresholdType $thresholdtype, array $attributes = []) : Model|IInnerThreshold {
        return $thresholdtype->inner_threshold_class::createNew($attributes);
    }

    private function syncInnerThreshold(ThresholdType $thresholdtype, Model|IInnerThreshold $innerthreshold = null, array $attributes = []) : IInnerThreshold {

        if ( is_null($innerthreshold) ) {
            // WARNING ! Make sure the association (via 'save' here) really happens
            $innerthreshold = $this->createInnerThreshold($thresholdtype, $attributes);
            $this->innerthreshold()->associate($innerthreshold);
        } else {
            if ($this->thresholdtype->id !== $thresholdtype->id) {
                // remove the old innerthreshold
                $this->removeInnerThreshold();

                // and we have to create a new one from new type
                $innerthreshold = $this->createInnerThreshold($thresholdtype, $attributes);

                $innerthreshold->attachUpperThreshold($this);
                $this->thresholdtype()->associate($thresholdtype);

                $this->save();
            } else {
                $this->innerthreshold->updateOne($attributes);
            }
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

        $innerrule->thresholdtype()->associate($default_treshold_type);
        $innerrule->save();

        return $innerrule;
    }

    public function updateOne(array $attributes = []) : AnalysisRuleThreshold
    {
        if ( ! empty($attributes) ) {

            $this->threshold = array_key_exists("threshold", $attributes) ? $attributes['threshold'] : $this->threshold;
            $this->comment = array_key_exists("comment", $attributes) ? $attributes['comment'] : $this->comment;

            $thresholdtype = $this->getTresholdTypeFromAttributes($attributes);
            if ($thresholdtype) {
                $this->syncInnerThreshold($thresholdtype, $this->innerthreshold, $attributes);
            }

            $this->save();
        }

        return $this;
    }

    private function getTresholdTypeFromAttributes(array $attributes): ?ThresholdType
    {
        if ( array_key_exists("thresholdtype", $attributes) ) {
            $thresholdtype_arr = is_string($attributes['thresholdtype']) ? json_decode($attributes['thresholdtype'], true) : $attributes['thresholdtype'];

            return ThresholdType::find( $thresholdtype_arr['id'] );
        } else {
            return null;
        }
    }

    #endregion

    public function ruleFollowed($input): bool
    {
        //return $this->thresholdtype->code == "min" ? ($input >= $this->threshold) : ($input <= $this->threshold);
        /*if ($this->thresholdtype->code == "min") {
            return ($input >= $this->threshold);
        } else {
            return ($input <= $this->threshold);
        }*/
        return $this->innerthreshold->applyRule($input) == RuleResultEnum::ALLOWED;
    }

    public function ruleBroken($input): bool
    {
        //return $this->thresholdtype->code == "min" ? ($input <= $this->threshold) : ($input >= $this->threshold);
        return $this->innerthreshold->applyRule($input) == RuleResultEnum::BROKEN;
    }

    public function applyRule($input): RuleResultEnum
    {
        return $this->innerthreshold->applyRule($input);
    }
}
