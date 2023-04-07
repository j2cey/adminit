<?php

namespace App\Http\Requests\FormattedValue;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use App\Models\FormattedValue\FormatType;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\FormattedValue\FormattedValue;
use App\Contracts\FormattedValue\IInnerFormattedValue;

/**
 * Class FormattedValueRequest
 * @package App\Http\Requests\FormattedValue
 *
 * @property string $title
 * @property string|null $header
 * @property string|null $body
 * @property string|null $footer
 * @property string $description
 *
 * @property Status $status
 * @property FormatType $formattype
 * @property IInnerFormattedValue $innerformattedvalue
 */
class FormattedValueRequest extends FormRequest
{
    use RequestTraits;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FormattedValue::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return FormattedValue::messagesRules();
    }
}
