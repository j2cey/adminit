<?php

namespace App\Contracts\AnalysisRules;

use App\Enums\RuleResultEnum;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\AnalysisRuleThreshold\AnalysisRuleThreshold;

/**
 * @method delete()
 */
interface IInnerThreshold extends Auditable
{
    public static function createNew(array $attributes = []);
    public function updateOne(array $attributes = []);

    public function analysisrulethreshold();
    public function attachUpperThreshold(AnalysisRuleThreshold $upperthreshold);

    public function applyRule($input): RuleResultEnum;
}
