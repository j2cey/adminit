<?php

namespace App\Http\Requests\FormatRuleType;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\FormatRule\FormatRuleType;

/**
 * Class UpdateFormatRuleTypeRequest
 * @package App\Http\Requests\StoreFormatRuleType
 *
 * @property FormatRuleType $formatruletype
 */
class UpdateFormatRuleTypeRequest extends FormatRuleTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::FormatRuleType()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FormatRuleType::updateRules($this->formatruletype);
    }
}
