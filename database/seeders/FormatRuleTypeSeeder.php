<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormatRule\FormatRuleType;
use App\Models\FormatRule\FormatTextSize;
use App\Models\FormatRule\FormatTextColor;
use App\Models\FormatRule\FormatTextWeight;

class FormatRuleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FormatRuleType::createNew("Text Color","text_color",FormatTextColor::class,"formattextcolor","Format Text Color");
        FormatRuleType::createNew("Text Size", "text_size",FormatTextSize::class,"formattextsize","Format Text Size");
        FormatRuleType::createNew("Text Weight","text_weight",FormatTextWeight::class,"formattextweight","Format Text Weight");
    }
}
