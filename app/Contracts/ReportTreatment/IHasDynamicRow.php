<?php

namespace App\Contracts\ReportTreatment;

use App\Models\DynamicValue\DynamicRow;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface IHasDynamicRow
{
    public function dynamicrow(): BelongsTo;
    public function setDynamicRow(DynamicRow $dynamicrow = null): static;
}
