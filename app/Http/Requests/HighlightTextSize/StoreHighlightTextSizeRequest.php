<?php

namespace App\Http\Requests\HighlightTextSize;

use App\Models\AnalysisRules\HighlightTextSize;

class StoreHighlightTextSizeRequest extends HighlightTextSizeRequest
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
        return HighlightTextSize::createRules();
    }
}
