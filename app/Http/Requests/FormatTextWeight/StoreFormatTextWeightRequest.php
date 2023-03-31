<?php

namespace App\Http\Requests\FormatTextWeight;

use App\Models\FormatRule\FormatTextWeight;

/**
 * Class StoreFormatTextWeightRequest
 * @package App\Http\Requests\FormatTextWeight
 *
 */
class StoreFormatTextWeightRequest extends FormatTextWeightRequest
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
        return FormatTextWeight::createRules();
    }
}
