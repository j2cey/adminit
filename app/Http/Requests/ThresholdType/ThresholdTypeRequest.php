<?php

namespace App\Http\Requests\ThresholdType;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Contracts\AnalysisRules\IInnerThreshold;
use App\Models\AnalysisRuleThreshold\ThresholdType;

/**
 * Class ThresholdTypeRequest
 * @package App\Http\Requests\ThresholdType
 *
 * @property string $label
 * @property string $code
 * @property string|IInnerThreshold $inner_threshold_class
 *
 * @property string $description
 *
 * @property Status $status
 */
class ThresholdTypeRequest extends FormRequest
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
        return ThresholdType::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ThresholdType::messagesRules();
    }
}
