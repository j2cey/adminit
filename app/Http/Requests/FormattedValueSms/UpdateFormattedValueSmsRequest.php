<?php

namespace App\Http\Requests\FormattedValueSms;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\FormattedValue\FormattedValueSms;

/**
 * @property FormattedValueSms $formattedvaluesms
 */
class UpdateFormattedValueSmsRequest extends FormattedValueSmsRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::FormattedValueSms()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FormattedValueSms::updateRules($this->formattedvaluesms);
    }
}
