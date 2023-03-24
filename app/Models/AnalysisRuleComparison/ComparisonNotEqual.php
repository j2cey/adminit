<?php

namespace App\Models\AnalysisRuleComparison;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\Comparison\InnerComparison;
use App\Contracts\AnalysisRules\IInnerComparison;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ComparisonNotEqual
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
class ComparisonNotEqual extends BaseModel implements IInnerComparison
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

    public static function createNew(): ComparisonNotEqual
    {
        return ComparisonNotEqual::create();
    }
}
