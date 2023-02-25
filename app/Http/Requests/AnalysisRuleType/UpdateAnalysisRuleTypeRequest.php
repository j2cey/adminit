<?php

namespace App\Http\Requests\AnalysisRuleType;

use App\Models\AnalysisRules\AnalysisRuleType;

class UpdateAnalysisRuleTypeRequest extends AnalysisRuleTypeRequest
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
        return AnalysisRuleType::updateRules($this->analysisruletype);
    }
}
