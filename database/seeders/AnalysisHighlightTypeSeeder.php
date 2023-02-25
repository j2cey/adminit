<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnalysisRules\AnalysisHighlightType;

class AnalysisHighlightTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnalysisHighlightType::createNew("Text Color","App\Models\AnalysisRules\HighlightTextColor","highlighttextcolor","Highlight Text Color");
        AnalysisHighlightType::createNew("Text Size","App\Models\AnalysisRules\HighlightTextSize","highlighttextsize","Highlight Text Size");
        AnalysisHighlightType::createNew("Text Weight","App\Models\AnalysisRules\HighlightTextWeight","highlighttextweight","Highlight Text Weight");
    }
}
