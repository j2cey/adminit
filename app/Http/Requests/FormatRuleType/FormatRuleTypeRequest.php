<?php

namespace App\Http\Requests\FormatRuleType;

use App\Traits\Request\RequestTraits;
use App\Models\FormatRule\FormatRuleType;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FormatRuleTypeRequest
 * @package App\Http\Requests\FormatRuleType
 *
 * @property string $name
 * @property string|IInnerFormatRule $model_type
 * @property string $view_name
 * @property string $description
 *
 */
class FormatRuleTypeRequest extends FormRequest
{
    use RequestTraits;

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
        return FormatRuleType::defaultRules();
    }
}
