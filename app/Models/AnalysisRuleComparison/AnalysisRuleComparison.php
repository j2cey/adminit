<?php

namespace App\Models\AnalysisRuleComparison;

use App\Models\BaseModel;
use App\Enums\RuleResultEnum;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AnalysisRules\InnerAnalysisRule;
use App\Contracts\AnalysisRules\IInnerComparison;
use App\Contracts\AnalysisRules\IInnerAnalysisRule;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AnalysisRuleComparison
 * @package App\Models\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $inner_operand
 * @property boolean $use_strict_comparison
 * @property boolean $use_type_comparison
 * @property string $comment
 * @property integer|null $comparison_type_id
 *
 * @property string|null $innercomparison_type
 * @property int|null $innercomparison_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property IInnerComparison $innercomparison
 * @property ComparisonType $comparisontype
 */
class AnalysisRuleComparison extends BaseModel implements IInnerAnalysisRule
{
    use InnerAnalysisRule, HasFactory;

    protected $guarded = [];
    protected $with = ['comparisontype','status'];
    protected $casts = [
        'use_strict_comparison' => 'boolean',
        'use_type_comparison' => 'boolean',
    ];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'innercomparison' => ['required'],
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
            'innercomparison.required' => "Prière de renseigner le Type",
        ];

    }

    #endregion

    #region Eloquent Relationships

    /**
     * @return BelongsTo
     */
    public function comparisontype()
    {
        return $this->belongsTo(ComparisonType::class,"comparison_type_id");
    }

    /**
     * @return MorphTo
     * Get the parent inner highlight model.
     */
    public function innercomparison()
    {
        return $this->morphTo();
    }

    #endregion

    #region Custom Functions

    public static function createInnerComparison(ComparisonType $comparisontype, array $attributes = []) : Model|IInnerComparison {
        return $comparisontype->inner_comparison_class::createNew($attributes);
    }

    private function syncInnerComparison(ComparisonType $comparisontype, Model|IInnerComparison $innercomparison = null, array $attributes = []) : IInnerComparison {

        if ( is_null($innercomparison) ) {
            // WARNING ! Make sure the association (via 'save' here) really happens
            $innercomparison = $this->createInnerComparison($comparisontype, $attributes);
            $this->innercomparison()->associate($innercomparison);
        } else {
            if ($this->comparisontype->id !== $comparisontype->id) {
                // remove the old innercomparison
                $this->removeInnerComparison();

                // and we have to create a new one from new type
                $innercomparison = $this->createInnerComparison($comparisontype);

                $innercomparison->attachUpperComparison($this);
                $this->comparisontype()->associate($comparisontype);

                $this->save();
            } else {
                $this->innercomparison->updateOne($attributes);
            }
        }

        return $innercomparison;
    }

    public function removeInnerComparison()
    {
        $this->innercomparison->delete();
    }

    public static function createNew(): AnalysisRuleComparison {

        $default_comparison_type = ComparisonType::getDefault();
        $innercomparison = self::createInnerComparison($default_comparison_type);

        $innerrule = $innercomparison->analysisrulecomparison()->create();

        $innerrule->comparisontype()->associate($default_comparison_type);
        $innerrule->save();

        return $innerrule;
    }

    public function updateOne(array $attributes = []) : AnalysisRuleComparison
    {
        if ( ! empty($attributes) ) {

            $this->inner_operand = array_key_exists("inner_operand", $attributes) ? $attributes['inner_operand'] : $this->inner_operand;
            $this->use_strict_comparison = array_key_exists("use_strict_comparison", $attributes) ? $attributes['use_strict_comparison'] : $this->use_strict_comparison;
            $this->use_type_comparison = array_key_exists("use_type_comparison", $attributes) ? $attributes['use_type_comparison'] : $this->use_type_comparison;
            $this->comment = array_key_exists("comment", $attributes) ? $attributes['comment'] : $this->comment;

            $comparisontype = $this->getComparisonTypeFromAttributes($attributes);
            if ($comparisontype) {
                $this->syncInnerComparison($comparisontype, $this->innercomparison);
            }

            $this->save();
        }

        return $this;
    }

    private function getComparisonTypeFromAttributes(array $attributes): ?ComparisonType
    {
        if ( array_key_exists("comparisontype", $attributes) ) {
            $thresholdtype_arr = is_string($attributes['comparisontype']) ? json_decode($attributes['comparisontype'], true) : $attributes['comparisontype'];

            return ComparisonType::find( $thresholdtype_arr['id'] );
        } else {
            return null;
        }
    }

    #endregion
    public function ruleFollowed($input): bool
    {
        return true;
    }

    public function ruleBroken($input): bool
    {
        return true;
    }

    public function applyRule($input): RuleResultEnum
    {
        return $this->innercomparison->applyRule($input,$this->inner_operand,$this->use_strict_comparison,$this->use_type_comparison);
    }
}
