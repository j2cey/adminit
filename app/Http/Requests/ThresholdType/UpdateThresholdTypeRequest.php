<?php

namespace App\Http\Requests\ThresholdType;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRuleThreshold\ThresholdType;

/**
 * Class UpdateThresholdTypeRequest
 * @package App\Http\Requests\UpdateThresholdType
 *
 * @property ThresholdType $thresholdtype
 */
class UpdateThresholdTypeRequest extends ThresholdTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ThresholdType()->update() );
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
