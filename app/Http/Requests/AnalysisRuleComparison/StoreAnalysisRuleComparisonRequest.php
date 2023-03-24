<?php

namespace App\Http\Requests\AnalysisRuleComparison;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRuleComparison\ComparisonType;
use App\Models\AnalysisRuleComparison\AnalysisRuleComparison;

/**
 * Class StoreAnalysisRuleComparisonRequest
 * @package App\Http\Requests\StoreAnalysisRuleComparison
 *
 */
class StoreAnalysisRuleComparisonRequest extends AnalysisRuleComparisonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::AnalysisRuleComparison()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return AnalysisRuleComparison::createRules();
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
            'comparisontype' => $this->getRelevantModel(ComparisonType::class, $this->input('comparisontype'),'id', false),
        ]);
    }
}
