<?php

namespace App\Contracts\AnalysisRules;

use App\Enums\RuleResultEnum;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\AnalysisRuleComparison\AnalysisRuleComparison;

/**
 * @method delete()
 */
interface IInnerComparison extends Auditable
{
    public static function createNew(array $attributes = []);
    public function updateOne(array $attributes = []);

    public function analysisrulecomparison();
    public function attachUpperComparison(AnalysisRuleComparison $uppercomparison);

    public function applyRule($left_operand, $right_operand, $use_strict_comparison = true, $use_type_comparison = false): RuleResultEnum;
}
