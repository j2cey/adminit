<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnalysisRules\ThresholdType;

class ThresholdTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThresholdType::createNew("Min Threshold", "min", "Min Threshold");
        ThresholdType::createNew("Max Threshold", "max", "Max Threshold")
            ->setDefault();
    }
}
