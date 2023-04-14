<?php

namespace App\Http\Requests\AnalysisRule;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRule\AnalysisRule;
use App\Contracts\AnalysisRules\IHasAnalysisRules;

/**
 * Class AnalysisRuleRequest
 * @package App\Http\Requests\AnalysisRule
 *
 * @property IHasAnalysisRules $model
 * @property string $model_type
 */
class StoreAnalysisRuleRequest extends AnalysisRuleRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::AnalysisRule()->create() );
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
            'status' => $this->setRelevantStatus($this->input('status'),'code', false),
            'model' => $this->input('model_type')::where('id', $this->input('model_id'))->first(),
            'rule_result_for_notification' => (is_null($this->input('rule_result_for_notification'))) ? null : $this->input('rule_result_for_notification')['value'],
            'analysisruletype' => $this->setAnalysisRuleType($this->input('analysisruletype'), 'id'),
        ]);
    }
}
