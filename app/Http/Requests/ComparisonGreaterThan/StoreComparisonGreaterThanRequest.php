<?php

namespace App\Http\Requests\ComparisonGreaterThan;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\AnalysisRuleComparison\ComparisonGreaterThan;

/**
 * Class StoreComparisonGreaterThanRequest
 * @package App\Http\Requests\ComparisonLessThan
 *
 */
class StoreComparisonGreaterThanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ComparisonGreaterThan()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ComparisonGreaterThan::createRules();
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
