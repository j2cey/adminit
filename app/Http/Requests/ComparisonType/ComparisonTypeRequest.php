<?php

namespace App\Http\Requests\ComparisonType;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Contracts\AnalysisRules\IInnerComparison;
use App\Models\AnalysisRuleComparison\ComparisonType;

/**
 * Class ComparisonTypeRequest
 * @package App\Http\Requests\ComparisonType
 *
 * @property string $label
 * @property string $code
 * @property string|IInnerComparison $inner_comparison_class
 *
 * @property string $description
 *
 * @property Status $status
 */
class ComparisonTypeRequest extends FormRequest
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
        return ComparisonType::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ComparisonType::messagesRules();
    }
}
