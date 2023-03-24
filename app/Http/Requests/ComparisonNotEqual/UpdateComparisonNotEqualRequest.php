<?php

namespace App\Http\Requests\ComparisonNotEqual;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRuleComparison\ComparisonNotEqual;

/**
 * Class UpdateComparisonNotEqualRequest
 * @package App\Http\Requests\UpdateComparisonNotEqual
 *
 * @property string $comment
 *
 * @property ComparisonNotEqual $comparisonnotequal
 */
class UpdateComparisonNotEqualRequest extends ComparisonNotEqualRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ComparisonNotEqual()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ComparisonNotEqual::updateRules($this->comparisonnotequal);
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
