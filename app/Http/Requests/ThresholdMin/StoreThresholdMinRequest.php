<?php

namespace App\Http\Requests\ThresholdMin;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\AnalysisRuleThreshold\ThresholdMin;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ThresholdMinRequest
 * @package App\Http\Requests\ThresholdMin
 *
 */
class StoreThresholdMinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ThresholdMin()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ThresholdMin::createRules();
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
