<?php

namespace App\Http\Requests\ComparisonGreaterThan;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRuleComparison\ComparisonGreaterThan;

/**
 * Class UpdateComparisonGreaterThanRequest
 * @package App\Http\Requests\UpdateComparisonGreaterThan
 *
 * @property string $comment
 *
 * @property ComparisonGreaterThan $comparisongreaterthan
 */
class UpdateComparisonGreaterThanRequest extends ComparisonGreaterThanRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ComparisonGreaterThan()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ComparisonGreaterThan::updateRules($this->comparisongreaterthan);
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
