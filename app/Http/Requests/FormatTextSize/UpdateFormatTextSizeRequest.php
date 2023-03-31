<?php

namespace App\Http\Requests\FormatTextSize;

use App\Models\FormatRule\FormatTextSize;

/**
 * Class FormatTextSizeRequest
 * @package App\Http\Requests\FormatTextSize
 *
 * @property FormatTextSize $formattextsize
 */
class UpdateFormatTextSizeRequest extends FormatTextSizeRequest
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
        return FormatTextSize::updateRules($this->formattextsize);
    }
}
