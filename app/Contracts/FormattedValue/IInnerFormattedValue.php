<?php

namespace App\Contracts\FormattedValue;

use App\Models\FormatRule\FormatRule;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\FormattedValue\FormattedValue;

/**
 * @property FormattedValue $formattedvalue
 */
interface IInnerFormattedValue extends Auditable
{
    public static function createNew(array $array = null);

    public function formattedvalue();
    public function attachUpperFormattedValue(FormattedValue $upperFormattedValue);

    public function applyFormat(mixed $value = null, FormatRule $formatrule = null, bool $reset = false);
    public function getFormattedValue();
    public function mergeRawValue(IInnerFormattedValue $innerformattedvalue, $value_to_merge);
    public function getRawValue();
}
