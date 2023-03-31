<?php

namespace App\Http\Requests\FormatTextWeight;

use App\Models\FormatRule\FormatTextWeight;

/**
 * Class UpdateFormatTextWeightRequest
 * @package App\Http\Requests\FormatTextWeight
 *
 * @property FormatTextWeight $formattextweight
 */
class UpdateFormatTextWeightRequest extends FormatTextWeightRequest
{
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
        return FormatTextWeight::updateRules($this->formattextweight);
    }
}
