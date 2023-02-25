<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DynamicAttributes\DynamicAttributeType;

class DynamicAttributeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DynamicAttributeType::createNew("String","App\Models\DynamicAttributes\DynamicValueString","");
        DynamicAttributeType::createNew("Integer","App\Models\DynamicAttributes\DynamicValueInteger","");
        DynamicAttributeType::createNew("DateTime","App\Models\DynamicAttributes\DynamicValueDatetime","");
        DynamicAttributeType::createNew("Boolean","App\Models\DynamicAttributes\DynamicValueBoolean","");
    }
}
