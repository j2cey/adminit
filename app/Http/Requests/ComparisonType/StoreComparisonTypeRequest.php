<?php

namespace App\Http\Requests\ComparisonType;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRuleComparison\ComparisonType;

/**
 * Class StoreComparisonTypeRequest
 * @package App\Http\Requests\ComparisonType
 *
 */
class StoreComparisonTypeRequest extends ComparisonTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ComparisonType()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ComparisonType::createRules();
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
