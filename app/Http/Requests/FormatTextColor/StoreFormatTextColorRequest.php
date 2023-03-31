<?php

namespace App\Http\Requests\FormatTextColor;

use App\Models\FormatRule\FormatTextColor;

/**
 * Class StoreFormatTextColorRequest
 * @package App\Http\Requests\FormatTextColor
 *
 */
class StoreFormatTextColorRequest extends FormatTextColorRequest
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
        return FormatTextColor::createRules();
    }
}
