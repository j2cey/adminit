<?php

namespace App\Http\Requests\AnalysisRule;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use App\Models\AnalysisRule\AnalysisRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\AnalysisRule\AnalysisRuleType;

/**
 * Class AnalysisRuleRequest
 * @package App\Http\Requests\AnalysisRule
 *
 * @property string $title
 * @property string $rule_result_for_notification
 * @property string $description
 * @property integer $num_ord
 *
 * @property integer|null $analysis_rule_type_id
 *
 * @property AnalysisRuleType $analysisruletype
 * @property Status $status
 */
class AnalysisRuleRequest extends FormRequest
{
    use RequestTraits;

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
        return AnalysisRule::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return AnalysisRule::messagesRules();
    }
}
