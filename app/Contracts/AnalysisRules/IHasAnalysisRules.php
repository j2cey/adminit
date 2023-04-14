<?php

namespace App\Contracts\AnalysisRules;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnalysisRule\AnalysisRule;
use App\Models\AnalysisRule\AnalysisRuleType;

/**
 * @property AnalysisRule[] $analysisrules
 */
interface IHasAnalysisRules
{
    public function analysisrules();
    public function analysisrulesOrdered();

    public function latestAnalysisRule();
    public function oldestAnalysisRule();

    public function addAnalysisRule(Model|AnalysisRuleType $analysisruletype, string $title, array $inneranalysisrule_attributes = [], string $rule_result_for_notification = null, Status $status = null, string $description = null): AnalysisRule;
}
