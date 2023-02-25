<?php

namespace App\Http\Requests\AnalysisRuleThreshold;

use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\AnalysisRules\AnalysisRuleThreshold;

/**
 * Class AnalysisRuleThresholdRequest
 * @package App\Http\Requests\AnalysisRuleThreshold
 *
 * @property integer $threshold
 *
 * @property string $comment
 * @property mixed $thresholdtype
 */
class AnalysisRuleThresholdRequest extends FormRequest
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
        return AnalysisRuleThreshold::defaultRules();
    }
}
