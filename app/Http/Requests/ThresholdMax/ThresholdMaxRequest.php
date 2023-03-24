<?php

namespace App\Http\Requests\ThresholdMax;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use App\Models\AnalysisRuleThreshold\ThresholdMax;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ThresholdMaxRequest
 * @package App\Http\Requests\ThresholdMax
 *
 * @property int $threshold
 * @property string $comment
 *
 * @property Status $status
 */
class ThresholdMaxRequest extends FormRequest
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
        return ThresholdMax::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ThresholdMax::messagesRules();
    }
}
