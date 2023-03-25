<?php

namespace App\Http\Requests\AnalysisRuleThreshold;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRuleThreshold\ThresholdType;
use App\Models\AnalysisRuleThreshold\AnalysisRuleThreshold;

/**
 * Class StoreAnalysisRuleThresholdRequest
 * @package App\Http\Requests\StoreAnalysisRuleThreshold
 *
 */
class StoreAnalysisRuleThresholdRequest extends AnalysisRuleThresholdRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::AnalysisRuleThreshold()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return AnalysisRuleThreshold::createRules();
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
            'thresholdtype' => $this->getRelevantModel(ThresholdType::class, $this->input('thresholdtype'),'id', false),
        ]);
    }
}
