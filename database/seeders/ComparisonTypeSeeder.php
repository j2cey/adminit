<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnalysisRuleComparison\ComparisonType;
use App\Models\AnalysisRuleComparison\ComparisonEqual;
use App\Models\AnalysisRuleComparison\ComparisonLessThan;
use App\Models\AnalysisRuleComparison\ComparisonNotEqual;
use App\Models\AnalysisRuleComparison\ComparisonGreaterThan;

class ComparisonTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ComparisonType::createNew("Plus Petit que...", ComparisonLessThan::class, "lessthan")
            ->setDefault();
        ComparisonType::createNew("Plus Grand que...", ComparisonGreaterThan::class, "greaterthan");
        ComparisonType::createNew("Egal à ...", ComparisonEqual::class, "equal");
        ComparisonType::createNew("Différent de ...", ComparisonNotEqual::class, "notequal");
    }
}
