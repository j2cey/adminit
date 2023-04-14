<?php

namespace App\Http\Requests\FormatRule;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use App\Models\FormatRule\FormatRule;
use App\Models\FormatRule\FormatRuleType;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FormatRuleRequest
 * @package App\Http\Requests\FormatRule
 *
 * @property int $num_ord
 * @property string $title
 * @property string $description
 *
 * @property integer|null $format_rule_type_id
 *
 * @property string $hasformatrule_type
 * @property int $hasformatrule_id
 *
 * @property string $rule_result
 *
 * @property Status $status
 * @property FormatRuleType $formatruletype
 * @property FormatRule $formatrule
 */
class FormatRuleRequest extends FormRequest
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
        return FormatRule::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return FormatRule::messagesRules();
    }
}
