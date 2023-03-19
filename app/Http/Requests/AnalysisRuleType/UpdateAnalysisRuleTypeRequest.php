<?php

namespace App\Http\Requests\AnalysisRuleType;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRules\AnalysisRuleType;

class UpdateAnalysisRuleTypeRequest extends AnalysisRuleTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::AnalysisRuleType()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return AnalysisRuleType::updateRules($this->analysisruletype);
    }
}
