<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnalysisRules\AnalysisRuleType;
use App\Models\AnalysisRuleThreshold\AnalysisRuleThreshold;
use App\Models\AnalysisRuleComparison\AnalysisRuleComparison;

class AnalysisRuleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnalysisRuleType::createNew("Threshold","threshold",AnalysisRuleThreshold::class,"analysisrulethreshold","Threshold analysis rule");
        AnalysisRuleType::createNew("Comparison", "comparison",AnalysisRuleComparison::class,"analysisrulecomparison","Comparison analysis rule");
    }
}
