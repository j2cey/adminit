<?php

namespace App\Traits\FormattedValue;

use App\Enums\HtmlTagKey;
use App\Models\FormatRule\FormatRule;
use Illuminate\Database\Eloquent\Collection;
use App\Models\FormattedValue\SmsFormattedValue;
use App\Models\FormattedValue\HtmlFormattedValue;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Contracts\FormattedValue\IHasFormattedValue;

/**
 * @property HtmlFormattedValue $htmlformattedvalue
 * @property SmsFormattedValue $smsformattedvalue
 */
trait HasFormattedValue
{
    /**
     * @return MorphOne
     */
    public function htmlformattedvalue()
    {
        return $this->morphOne(HtmlFormattedValue::class, 'hasformattedvalue');
    }

    /**
     * @return MorphOne
     */
    public function smsformattedvalue()
    {
        return $this->morphOne(SmsFormattedValue::class, 'hasformattedvalue');
    }

    public function setFormattedValue(HtmlTagKey $tagkey = null, $rawvalue = null) {
        $data = [];
        if ( ! is_null($rawvalue) ) {
            $data['rawvalue'] = $rawvalue;
        }
        if ( is_null( $this->htmlformattedvalue ) ) {
            $data['maintag'] = $tagkey->value;
            $this->htmlformattedvalue()->save(HtmlFormattedValue::createNew($data));
        }
        if ( is_null( $this->smsformattedvalue ) ) {
            $this->smsformattedvalue()->save(SmsFormattedValue::createNew($data));
        }
    }

    /**
     * @param mixed|null $value
     * @param Collection|FormatRule[]|null $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormatFromRaw(mixed $value = null, Collection $formatrules = null, bool $reset = false) {
        $this->htmlformattedvalue->applyFormat(
            $value ?? $this->htmlformattedvalue->getRawValue(),
            $formatrules,
            $reset
        );
        $this->smsformattedvalue->applyFormat($value ?? $this->smsformattedvalue->getRawValue(), $formatrules, $reset);
    }

    /**
     * @param mixed|null $value
     * @param Collection|FormatRule[]|null $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormatFromFormatted(mixed $value = null, Collection $formatrules = null, bool $reset = false) {
        $this->htmlformattedvalue->applyFormat($value ?? $this->htmlformattedvalue->getFormattedValue(), $formatrules, $reset);
        $this->smsformattedvalue->applyFormat($value ?? $this->smsformattedvalue->getFormattedValue(), $formatrules, $reset);
    }

    public function mergeRawValues(IHasFormattedValue $hasformattedvalue) {
        $this->htmlformattedvalue->mergeRawValue($hasformattedvalue->htmlformattedvalue, $hasformattedvalue->htmlformattedvalue->getRawValue());
        $this->smsformattedvalue->mergeRawValue($hasformattedvalue->smsformattedvalue, $hasformattedvalue->htmlformattedvalue->getRawValue());
    }
    public function mergeRawValueFromFormatted(IHasFormattedValue $hasformattedvalue) {
        $this->htmlformattedvalue->mergeRawValue($hasformattedvalue->htmlformattedvalue, $hasformattedvalue->htmlformattedvalue->getFormattedValue());
        $this->smsformattedvalue->mergeRawValue($hasformattedvalue->smsformattedvalue, $hasformattedvalue->htmlformattedvalue->getFormattedValue());
    }

    public function insertHeadersRow(array $headers) {
        $this->htmlformattedvalue->insertHeadersRow($headers);
        $this->smsformattedvalue->insertHeadersRow($headers);
    }

    public function resetRawValues() {
        $this->htmlformattedvalue->resetRawValue();
        $this->smsformattedvalue->resetRawValue();
    }

    public function removeFormattedValues() {
        $this->htmlformattedvalue->delete();
        $this->smsformattedvalue->delete();
    }

    #endregion

    protected function initializeHasFormattedValue()
    {
        $this->with = array_unique(array_merge($this->with, ['htmlformattedvalue']));
        $this->with = array_unique(array_merge($this->with, ['smsformattedvalue']));
    }

    public static function bootHasFormattedValue()
    {
        static::deleting(function ($model) {
            $model->removeFormattedValues();
        });
    }
}
