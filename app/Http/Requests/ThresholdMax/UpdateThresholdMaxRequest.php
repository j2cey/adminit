<?php

namespace App\Http\Requests\ThresholdMax;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRuleThreshold\ThresholdMax;

/**
 * Class UpdateThresholdMaxRequest
 * @package App\Http\Requests\ThresholdMax
 *
 * @property int $threshold
 * @property string $comment
 *
 * @property ThresholdMax $thresholdmax
 */
class UpdateThresholdMaxRequest extends ThresholdMaxRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ThresholdMax()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ThresholdMax::updateRules($this->thresholdmax);
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
