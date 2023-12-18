<?php

namespace App\Contracts\ReportTreatment;

use App\Models\DynamicValue\DynamicValue;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface IHasDynamicValue
{
    public function dynamicvalue(): BelongsTo;
    public function setDynamicValue(DynamicValue $dynamicvalue = null): static;
}
