<?php

namespace App\Contracts\AnalysisRules;

use OwenIt\Auditing\Contracts\Auditable;
use App\Models\AnalysisRuleComparison\AnalysisRuleComparison;

/**
 * @method delete()
 */
interface IInnerComparison extends Auditable
{
    public static function createNew();

    public function analysisrulecomparison();
    public function attachUpperComparison(AnalysisRuleComparison $uppercomparison);
}
