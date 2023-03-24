<?php

namespace App\Http\Requests\HighlightTextColor;

use App\Models\AnalysisHighlight\HighlightTextColor;

class StoreHighlightTextColorRequest extends HighlightTextColorRequest
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
        return HighlightTextColor::createRules();
    }
}
