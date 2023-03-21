<?php

namespace App\Http\Requests\AnalysisHighlightType;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRules\AnalysisHighlightType;

class UpdateAnalysisHighlightTypeRequest extends AnalysisHighlightTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::AnalysisHighlightType()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return AnalysisHighlightType::updateRules($this->analysishighlighttype);
    }
}
