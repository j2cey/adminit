<?php

namespace App\Http\Requests\FormatRule;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\FormatRule\FormatRule;
use App\Models\FormatRule\FormatRuleType;
use App\Contracts\FormatRule\IHasFormatRules;

/**
 * Class FormatRuleRequest
 * @package App\Http\Requests\FormatRule
 *
 * @property IHasFormatRules $model
 * @property string $model_type
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
            'status' => $this->setRelevantStatus($this->input('status'), "íd", false),
            'model' => $this->input('model_type')::find($this->input('model_id'))->first(),
            'formatruletype_key' => $this->getRelevantModelId($this->input('formatruletype'), false),
            'formatruletype' => $this->getRelevantModel(FormatRuleType::class, $this->input('formatruletype'), 'id'),
        ]);
    }
}
