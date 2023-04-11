<?php

namespace App\Contracts\FormattedValue;

use App\Enums\HtmlTagKey;
use App\Models\FormatRule\FormatRule;
use Illuminate\Database\Eloquent\Collection;

interface IHasFormattedValue
{
    public function htmlformattedvalue();
    public function smsformattedvalue();

    public function setFormattedValue(HtmlTagKey $tagkey = null, $rawvalue = null);

    /**
     * @param mixed|null $value
     * @param Collection|FormatRule[]|null $formatrules
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

    public function mergeRawValueFromFormatted(IHasFormattedValue $hasformattedvalue);

    public function insertHeadersRow(array $headers);
}
