<?php

namespace App\Http\Requests\ComparisonLessThan;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\AnalysisRuleComparison\ComparisonLessThan;

/**
 * Class ComparisonLessThanRequest
 * @package App\Http\Requests\ComparisonLessThan
 *
 * @property string $comment
 *
 * @property Status $status
 */
class ComparisonLessThanRequest extends FormRequest
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
        return ComparisonLessThan::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ComparisonLessThan::messagesRules();
    }
}