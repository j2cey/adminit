<?php

namespace App\Http\Requests\ComparisonLessThan;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRuleComparison\ComparisonLessThan;

/**
 * Class UpdateThresholdMaxRequest
 * @package App\Http\Requests\ThresholdMax
 *
 * @property string $comment
 *
 * @property ComparisonLessThan $comparisonlessthan
 */
class UpdateComparisonLessThanRequest extends ComparisonLessThanRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ComparisonLessThan()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ComparisonLessThan::updateRules($this->comparisonlessthan);
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
        ]);
    }
}
