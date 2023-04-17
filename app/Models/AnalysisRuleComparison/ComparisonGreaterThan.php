<?php

namespace App\Models\AnalysisRuleComparison;

use App\Models\BaseModel;
use App\Enums\RuleResultEnum;
use Illuminate\Support\Carbon;
use App\Traits\Comparison\InnerComparison;
use App\Contracts\AnalysisRules\IInnerComparison;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ComparisonGreaterThan
 * @package App\Models\Comparison
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ComparisonGreaterThan extends BaseModel implements IInnerComparison
{
    use HasFactory, InnerComparison;

    #region Validation Rules

    public static function defaultRules() {
        return [
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

    public static function createNew(array $attributes = []): ComparisonGreaterThan
    {
        return ComparisonGreaterThan::create();
    }

    public function updateOne(array $attributes = []) {

    }

    public function applyRule($left_operand, $right_operand, $use_strict_comparison = true, $use_type_comparison = false): RuleResultEnum
    {
        if ( $use_strict_comparison ) {
            return ( $left_operand > $right_operand ) ? RuleResultEnum::ALLOWED : RuleResultEnum::BROKEN;
        } else {
            return ( $left_operand >= $right_operand ) ? RuleResultEnum::ALLOWED : RuleResultEnum::BROKEN;
        }
    }
}
