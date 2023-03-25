<?php

namespace App\Models\AnalysisRuleComparison;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\AnalysisRules\IsInnerRule;
use App\Contracts\AnalysisRules\IInnerRule;
use App\Contracts\AnalysisRules\IInnerComparison;
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
 * @property boolean $with_equality
 * @property integer|null $comparison_type_id
 *
 * @property string $comment
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
class AnalysisRuleComparison extends BaseModel implements IInnerRule
{
    use IsInnerRule, HasFactory;

    protected $guarded = [];
    protected $with = ['comparisontype','status'];

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

    public static function createInnerComparison(ComparisonType $comparisontype) : IInnerComparison {
        return $comparisontype->inner_comparison_class::createNew();
    }

    private function syncInnerComparison(ComparisonType $comparisontype, IInnerComparison $innercomparison) : IInnerComparison {

        if ( $this->comparisontype->id !== $comparisontype->id ) {
            // remove the old innercomparison
            $this->removeInnerComparison();

            // and we have to create a new one from new type
            $innercomparison = $this->createInnerComparison($comparisontype);

            $innercomparison->attachUpperComparison($this);
            $this->comparisontype()->associate($comparisontype);

            $this->save();
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

        $innerrule->save();

        return $innerrule;
    }

    public function updateOne(ComparisonType $comparisontype, $with_equality, $comment) : AnalysisRuleComparison
    {
        $this->syncInnerComparison($comparisontype, $this->innercomparison);

        $this->with_equality = $with_equality;
        $this->comment = $comment;

        $this->save();

        return $this;
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
}
