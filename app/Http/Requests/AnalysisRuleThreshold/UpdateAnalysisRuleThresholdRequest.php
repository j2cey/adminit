<?php

namespace App\Http\Requests\AnalysisRuleThreshold;

use App\Models\AnalysisRules\AnalysisRuleThreshold;

/**
 * Class UpdateAnalysisRuleThresholdRequest
 * @package App\Http\Requests\AnalysisRuleThreshold
 *
 */
class UpdateAnalysisRuleThresholdRequest extends AnalysisRuleThresholdRequest
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
        return AnalysisRuleThreshold::updateRules($this->analysisrulethreshold);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'thresholdtype' => $this->setRelevantThresholdType($this->input('thresholdtype'), "code", true),
        ]);
    }
}
