<?php

namespace App\Contracts\FormattedValue;

use App\Models\FormatRule\FormatRule;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property IHasFormattedValue $hasformattedvalue
 */
interface IFormattedValue extends Auditable
{
    public static function createNew(array $array = null);

    public function hasformattedvalue();

    /**
     * @param mixed|null $value
     * @param Collection|FormatRule[]|null $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormat(mixed $value = null, Collection $formatrules = null, bool $reset = false);

    /**
     * @param mixed|null $value
     * @param Collection|FormatRule[] $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormatFromRaw(mixed $value = null, Collection $formatrules = null, bool $reset = false);

    /**
     * @param mixed|null $value
     * @param Collection|FormatRule[]|null $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormatFromFormatted(mixed $value = null, Collection $formatrules = null, bool $reset = false);

    public function getFormattedValue(): mixed;
    public function mergeRawValue(IFormattedValue $innerformattedvalue, $value_to_merge);
    public function getRawValue();
    public function resetRawValue();
    public function insertHeadersRow(array $headers);
}
