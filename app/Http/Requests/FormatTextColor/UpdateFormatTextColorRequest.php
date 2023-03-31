<?php

namespace App\Http\Requests\FormatTextColor;

use App\Models\FormatRule\FormatTextColor;

/**
 * Class FormatTextColorRequest
 * @package App\Http\Requests\FormatTextColor
 *
 * @property FormatTextColor $formattextcolor
 */
class UpdateFormatTextColorRequest extends FormatTextColorRequest
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
        return FormatTextColor::updateRules($this->formattextcolor);
    }
}
