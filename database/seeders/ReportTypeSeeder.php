<?php

namespace Database\Seeders;

use App\Models\Reports\ReportType;
use Illuminate\Database\Seeder;

class ReportTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReportType::createNew("Default Report","");
    }
}
