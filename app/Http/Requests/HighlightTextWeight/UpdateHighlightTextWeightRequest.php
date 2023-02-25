<?php

namespace App\Http\Requests\HighlightTextWeight;

use App\Models\AnalysisRules\HighlightTextWeight;

class UpdateHighlightTextWeightRequest extends HighlightTextWeightRequest
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
        return HighlightTextWeight::updateRules($this->highlighttextweight);
    }
}
