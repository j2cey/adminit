<?php

namespace App\Http\Requests\AnalysisRuleComparison;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\AnalysisRuleComparison\ComparisonType;
use App\Models\AnalysisRuleComparison\AnalysisRuleComparison;

/**
 * Class AnalysisRuleComparisonRequest
 * @package App\Http\Requests\AnalysisRuleComparison
 *
 * @property boolean $with_equality
 * @property string $comment
 *
 * @property Status $status
 * @property ComparisonType $comparisontype
 */
class AnalysisRuleComparisonRequest extends FormRequest
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
        return AnalysisRuleComparison::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return AnalysisRuleComparison::messagesRules();
    }
}
