<?php

namespace App\Http\Requests\HighlightTextColor;

use App\Models\AnalysisRules\HighlightTextColor;

class UpdateHighlightTextColorRequest extends HighlightTextColorRequest
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
        return HighlightTextColor::updateRules($this->highlighttextcolor);
    }
}
