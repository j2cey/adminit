<?php

namespace App\Http\Requests\ComparisonEqual;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\AnalysisRuleComparison\ComparisonEqual;

/**
 * Class ComparisonEqualRequest
 * @package App\Http\Requests\ComparisonEqual
 *
 * @property string $comment
 *
 * @property Status $status
 */
class ComparisonEqualRequest extends FormRequest
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
        return ComparisonEqual::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ComparisonEqual::messagesRules();
    }
}
