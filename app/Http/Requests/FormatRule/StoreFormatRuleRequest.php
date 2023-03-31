<?php

namespace App\Http\Requests\FormatRule;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\FormatRule\FormatRule;
use App\Models\FormatRule\FormatRuleType;

/**
 * Class FormatRuleRequest
 * @package App\Http\Requests\FormatRule
 *
 */
class StoreFormatRuleRequest extends FormatRuleRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::FormatRule()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FormatRule::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'formatruletype' => $this->getRelevantModel(FormatRuleType::class, $this->input('formatruletype'), 'id'),
        ]);
    }
}
