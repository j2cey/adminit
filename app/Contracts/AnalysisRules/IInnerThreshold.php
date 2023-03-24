<?php

namespace App\Contracts\AnalysisRules;

use OwenIt\Auditing\Contracts\Auditable;
use App\Models\AnalysisRuleThreshold\AnalysisRuleThreshold;

/**
 * @method delete()
 */
interface IInnerThreshold extends Auditable
{
    public static function createNew();

    public function analysisrulethreshold();
    public function attachUpperThreshold(AnalysisRuleThreshold $upperthreshold);
}
