<?php

namespace App\Http\Requests\AnalysisRuleType;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\AnalysisRules\AnalysisRuleType;

class AnalysisRuleTypeRequest extends FormRequest
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
        return AnalysisRuleType::defaultRules();
    }
}
