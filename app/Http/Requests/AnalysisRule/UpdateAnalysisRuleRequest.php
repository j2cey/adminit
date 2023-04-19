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
 * @property array $inneranalysisrule_attributes
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
            'analysisruletype' => $this->setAnalysisRuleType($this->input('analysisruletype'), 'id', true),
            'rule_result_for_notification' => (is_null($this->input('rule_result_for_notification'))) ? null : $this->decodeJsonField($this->input('rule_result_for_notification'))['value'],
            'inneranalysisrule_attributes' => $this->decodeJsonField( $this->input('inneranalysisrule') ?? $this->input('inneranalysisrule_attributes') ),
        ]);
    }
}
