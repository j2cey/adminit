<?php

namespace App\Http\Requests\FormattedValueHtml;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\FormattedValue\FormattedValueHtml;

class StoreFormattedValueHtmlRequest extends FormattedValueHtmlRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::FormattedValueHtml()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FormattedValueHtml::createRules();
    }
}
