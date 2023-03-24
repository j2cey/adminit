<?php

namespace App\Http\Requests\ThresholdMin;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRuleThreshold\ThresholdMin;

/**
 * Class UpdateThresholdMinRequest
 * @package App\Http\Requests\ThresholdMin
 *
 * @property int $threshold
 * @property string $comment
 *
 * @property ThresholdMin $thresholdmin
 */
class UpdateThresholdMinRequest extends ThresholdMinRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ThresholdMin()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ThresholdMin::updateRules($this->thresholdmin);
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
