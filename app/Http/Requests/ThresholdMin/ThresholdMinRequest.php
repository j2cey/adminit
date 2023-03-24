<?php

namespace App\Http\Requests\ThresholdMin;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use App\Models\AnalysisRuleThreshold\ThresholdMin;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ThresholdMinRequest
 * @package App\Http\Requests\ThresholdMin
 *
 * @property int $threshold
 * @property string $comment
 *
 * @property Status $status
 */
class ThresholdMinRequest extends FormRequest
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
        return ThresholdMin::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ThresholdMin::messagesRules();
    }
}
