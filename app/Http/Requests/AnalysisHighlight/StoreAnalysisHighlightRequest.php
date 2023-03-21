<?php

namespace App\Http\Requests\AnalysisHighlight;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRules\AnalysisHighlight;

class StoreAnalysisHighlightRequest extends AnalysisHighlightRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::AnalysisHighlight()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return AnalysisHighlight::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'analysisrule' => $this->setAnalysisRule(
                json_encode( ['id' => $this->input('analysis_rule_id')] ),'id', true
            ),
            'highlighttype' => $this->setAnalysisHighlightType($this->input('highlighttype'), 'id'),
        ]);
    }
}
