<?php

namespace App\Contracts\FormattedValue;

use App\Models\Status;
use App\Models\FormatRule\FormatRule;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\FormattedValue\FormatType;
use App\Models\FormattedValue\FormattedValue;

interface IHasFormattedValues extends Auditable
{
    public function formattedvalues();

    public function setFormattedValue(Model|FormatType $formattype, string $title, Status $status = null, string $description = null): FormattedValue;

    public function applyFormat(mixed $value = null, FormatRule $formatrule = null, bool $reset = false);
}
