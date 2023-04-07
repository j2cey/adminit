<?php

namespace App\Traits\FormattedValue;

use App\Models\Status;
use App\Enums\HtmlTagKey;
use OwenIt\Auditing\Auditable;
use App\Models\FormatRule\FormatRule;
use Illuminate\Database\Eloquent\Model;
use App\Models\FormattedValue\FormatType;
use App\Models\FormattedValue\FormattedValue;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Contracts\FormattedValue\IFormattedValueHtml;
use App\Contracts\FormattedValue\IInnerFormattedValue;

/**
 * @property FormattedValue[] $formattedvalues
 * @property FormattedValue $htmlformattedvalue
 * @property IFormattedValueHtml $formattedvaluehtml
 */
trait HasFormattedValues
{
    use Auditable;

    /**
     * Get the model's formatted values
     * @return MorphMany
     */
    public function formattedvalues()
    {
        return $this->morphMany(FormattedValue::class, 'hasformattedvalue');
    }

    /**
     * @return MorphOne
     */
    public function htmlformattedvalue()
    {
        return $this->morphOne(FormattedValue::class, 'hasformattedvalue')
            ->where('format_type_id', FormatType::html()->first()->id);
    }

    public function getFormattedvaluehtmlAttribute()
    {
        return $this->htmlformattedvalue->innerformattedvalue;
    }

    #region Custom Functions

    /**
     * @param Model|FormatType $formattype
     * @param string $title
     * @param Status|null $status
     * @param string|null $description
     * @return FormattedValue
     */
    public function setFormattedValue(Model|FormatType $formattype, string $title, Status $status = null, string $description = null): FormattedValue
    {
        $formattedvalue = FormattedValue::createNew(
            $formattype,
            $title,
            $status,
            $description,
        );                                                      // create new FormattedValue + InnerFormattedValue
        $this->formattedvalues()->save($formattedvalue);        // attach the new FormattedValue to the current model object

        if ( ! is_null($status) ) {
            $formattedvalue->status()->associate($status);      // set status
        }

        $formattedvalue->save();                                // save the association from the FormattedValue

        return $formattedvalue;
    }

    /**
     * @param Model|FormatType $formattype
     * @param string $title
     * @param Status|null $status
     * @param string|null $description
     * @return IInnerFormattedValue|IFormattedValueHtml
     */
    public function setFormattedValueHtml(Model|FormatType $formattype, string $title, Status $status = null, string $description = null) {
        $formattedvalue = $this->setFormattedValue($formattype, $title, $status, $description);
        return $formattedvalue->innerformattedvalue;
    }

    public function setFormattedValues(HtmlTagKey $tagkey = null) {
        if ($this->formattedvalues()->count() === 0) {
            // set Html value
            $innerformattedvalue = $this->setFormattedValueHtml(FormatType::html()->first(), "html value");
            if (!is_null($tagkey)) {
                $innerformattedvalue->setMainTag($tagkey);
            }
            // set sms value
            $this->setFormattedValue(FormatType::sms()->first(), "sms value");
        }
    }

    public function applyFormat(mixed $value = null, FormatRule $formatrule = null, bool $reset = false) {
        foreach ($this->formattedvalues as $formattedvalue) {
            $formatrules = FormatRule::all();
            foreach ($formatrules as $formatrule) {
                $formattedvalue->innerformattedvalue->applyFormat($value, $formatrule, $reset);
            }
        }
    }

    #endregion

    protected function initializeHasFormattedValues()
    {
        $this->with = array_unique(array_merge($this->with, ['formattedvalues']));
    }

    public static function bootHasFormattedValues()
    {
        static::deleting(function ($model) {
            $model->formattedvalues()->each(function ($formattedvalue) {
                $formattedvalue->delete(); // <-- direct deletion
            });
        });
    }
}
