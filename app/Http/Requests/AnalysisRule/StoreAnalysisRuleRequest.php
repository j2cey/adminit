<?php

namespace App\Http\Requests\AnalysisRule;

use App\Models\AnalysisRules\AnalysisRule;

class StoreAnalysisRuleRequest extends AnalysisRuleRequest
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
        return AnalysisRule::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'dynamicattribute' => $this->setRelevantDynamicAttribute(
                json_encode( ['id' => $this->input('dynamic_attribute_id')] ),'id', true
            ),
            'alert_when_allowed' => $this->setCheckOrOptionValue($this->input('alert_when_allowed')),
            'alert_when_broken' => $this->setCheckOrOptionValue($this->input('alert_when_broken')),
            'analysisruletype' => $this->setAnalysisRuleType($this->input('analysisruletype'), 'id'),
        ]);
    }
}
