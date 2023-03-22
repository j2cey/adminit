<?php

namespace Database\Seeders;

use App\Enums\ValueTypeEnum;
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
        DynamicAttributeType::createNew("String", ValueTypeEnum::STRING->value,"App\Models\DynamicAttributes\DynamicValueString");
        DynamicAttributeType::createNew("Integer", ValueTypeEnum::INT->value,"App\Models\DynamicAttributes\DynamicValueInteger");
        DynamicAttributeType::createNew("DateTime", ValueTypeEnum::DATETIME->value,"App\Models\DynamicAttributes\DynamicValueDatetime");
        DynamicAttributeType::createNew("Boolean", ValueTypeEnum::BOOLEAN->value,"App\Models\DynamicAttributes\DynamicValueBoolean");
    }
}
