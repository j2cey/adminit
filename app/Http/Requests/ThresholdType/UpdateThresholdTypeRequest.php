<?php

namespace App\Http\Requests\ThresholdType;

use App\Models\AnalysisRules\ThresholdType;

class UpdateThresholdTypeRequest extends ThresholdTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ThresholdType::updateRules($this->thresholdtype);
    }
}
