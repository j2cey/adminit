<?php

namespace App\Http\Requests\ComparisonEqual;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRuleComparison\ComparisonEqual;

/**
 * Class StoreComparisonEqualRequest
 * @package App\Http\Requests\StoreComparisonEqual
 *
 */
class StoreComparisonEqualRequest extends ComparisonEqualRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ComparisonEqual()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ComparisonEqual::createRules();
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
        ]);
    }
}
