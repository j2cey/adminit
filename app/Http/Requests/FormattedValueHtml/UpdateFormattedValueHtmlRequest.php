<?php

namespace App\Http\Requests\FormattedValueHtml;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\FormattedValue\FormattedValueHtml;

/**
 * @property FormattedValueHtml $formattedvaluehtml
 */
class UpdateFormattedValueHtmlRequest extends FormattedValueHtmlRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::FormattedValueHtml()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FormattedValueHtml::updateRules($this->formattedvaluehtml);
    }
}
