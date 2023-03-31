<?php

namespace App\Http\Requests\FormatRuleType;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\FormatRule\FormatRuleType;

/**
 * Class StoreFormatRuleTypeRequest
 * @package App\Http\Requests\StoreFormatRuleType
 *
 */
class StoreFormatRuleTypeRequest extends FormatRuleTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::FormatRuleType()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FormatRuleType::createRules();
    }
}
