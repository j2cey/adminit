<?php

namespace App\Http\Requests\ComparisonEqual;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRuleComparison\ComparisonEqual;

/**
 * Class UpdateComparisonEqualRequest
 * @package App\Http\Requests\UpdateComparisonEqual
 *
 * @property string $comment
 *
 * @property ComparisonEqual $comparisonequal
 */
class UpdateComparisonEqualRequest extends ComparisonEqualRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ComparisonEqual()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ComparisonEqual::updateRules($this->comparisonequal);
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
