<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormattedValue\FormatType;
use App\Models\FormattedValue\FormattedValueSms;
use App\Models\FormattedValue\FormattedValueHtml;

class FormatTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FormatType::createNew("HTML Format","html",FormattedValueHtml::class);
        FormatType::createNew("SMS Format","sms",FormattedValueSms::class);
    }
}
