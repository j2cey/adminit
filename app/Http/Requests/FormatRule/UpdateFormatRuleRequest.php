<?php

namespace App\Http\Requests\FormatRule;

use App\Models\Status;
use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\FormatRule\FormatRule;
use App\Models\FormatRule\FormatRuleType;

/**
 * Class UpdateFormatRuleRequest
 * @package App\Http\Requests\FormatRule
 *
 * @property FormatRule $formatrule
 */
class UpdateFormatRuleRequest extends FormatRuleRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::FormatRule()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FormatRule::updateRules($this->formatrule);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->getrelevantModelByCode(Status::class, $this->status, true),
            'formatruletype' => $this->getRelevantModel(FormatRuleType::class, $this->input('formatruletype'), 'id', true),
        ]);
    }
}
