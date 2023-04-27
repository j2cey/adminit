<?php

namespace App\Contracts\RowConfig;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use App\Models\RowConfig\LastRowConfig;
use App\Models\DynamicAttributes\DynamicAttribute;

interface IHasLastRowConfig
{
    public function lastrowconfig();
    public function setLastRowConfig(
        bool $ref_by_row_num = null,
        int $row_num = null,
        bool $ref_by_attribute_value = null,
        DynamicAttribute|Model $dynamicattribute = null,
        string $attribute_value = null,
        Status $status = null,
        string $description = null): ?LastRowConfig;
}
