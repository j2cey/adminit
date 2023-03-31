<?php

namespace App\Http\Requests\AnalysisRule;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRule\AnalysisRule;

/**
 * Class AnalysisRuleRequest
 * @package App\Http\Requests\AnalysisRule
 *
 * @property AnalysisRule $analysisrule
 */
class UpdateAnalysisRuleRequest extends AnalysisRuleRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::AnalysisRule()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return AnalysisRule::updateRules($this->analysisrule);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->setRelevantStatus($this->input('status'),'code', true),
            'alert_when_allowed' => $this->setCheckOrOptionValue($this->input('alert_when_allowed')),
            'alert_when_broken' => $this->setCheckOrOptionValue($this->input('alert_when_broken')),
            'analysisruletype' => $this->setAnalysisRuleType($this->input('analysisruletype'), 'id', true),
        ]);
    }
}
