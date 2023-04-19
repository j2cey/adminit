<?php

namespace App\Contracts\AnalysisRules;

use App\Models\AnalysisRule\AnalysisRule;

/**
 * @property AnalysisRule[] $matchedanalysisrules
 */
interface IHasMatchedAnalysisRules
{
    public function matchedanalysisrules();
    public function addMatchedAnalysisRule(AnalysisRule $analysisrule);
    public function resetMatchedAnalysisRules();
}
