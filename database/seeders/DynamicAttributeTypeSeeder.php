<?php

namespace Database\Seeders;

use App\Enums\ValueTypeEnum;
use Illuminate\Database\Seeder;
use App\Models\DynamicValue\DynamicValueString;
use App\Models\DynamicValue\DynamicValueInteger;
use App\Models\DynamicValue\DynamicValueBoolean;
use App\Models\DynamicValue\DynamicValueDatetime;
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
        DynamicAttributeType::createNew("String", ValueTypeEnum::STRING->value,DynamicValueString::class);
        DynamicAttributeType::createNew("Integer", ValueTypeEnum::INT->value,DynamicValueInteger::class);
        DynamicAttributeType::createNew("DateTime", ValueTypeEnum::DATETIME->value,DynamicValueDatetime::class);
        DynamicAttributeType::createNew("Boolean", ValueTypeEnum::BOOLEAN->value,DynamicValueBoolean::class);
    }
}
