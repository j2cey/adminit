<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnalysisRuleThreshold\ThresholdMin;
use App\Models\AnalysisRuleThreshold\ThresholdMax;
use App\Models\AnalysisRuleThreshold\ThresholdType;

class ThresholdTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThresholdType::createNew("Min Threshold", ThresholdMin::class, "min", "Min Threshold");
        ThresholdType::createNew("Max Threshold", ThresholdMax::class, "max", "Max Threshold")
            ->setDefault();
    }
}
