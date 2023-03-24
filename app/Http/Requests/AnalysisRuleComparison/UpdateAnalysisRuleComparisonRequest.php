<?php

namespace App\Http\Requests\AnalysisRuleComparison;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRuleComparison\ComparisonType;
use App\Models\AnalysisRuleComparison\AnalysisRuleComparison;

/**
 * Class AnalysisRuleComparisonRequest
 * @package App\Http\Requests\AnalysisRuleComparison
 *
 * @property integer $comparison
 *
 * @property string $comment
 * @property ComparisonType $comparisontype
 * @property AnalysisRuleComparison $analysisrulecomparison
 */
class UpdateAnalysisRuleComparisonRequest extends AnalysisRuleComparisonRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::AnalysisRuleComparison()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return AnalysisRuleComparison::updateRules($this->analysisrulecomparison);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->setRelevantStatus($this->input('status'),'code', true),
            'comparisontype' => $this->getRelevantModel(AnalysisRuleComparison::class, $this->input('comparisontype'), "code", true),
        ]);
    }
}
