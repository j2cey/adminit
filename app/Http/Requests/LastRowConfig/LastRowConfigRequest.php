<?php

namespace App\Http\Requests\LastRowConfig;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use App\Models\RowConfig\LastRowConfig;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\DynamicAttributes\DynamicAttribute;

/**
 * Class LastRowConfigRequest
 * @package App\Http\Requests\LastRowConfig
 *
 * @property boolean $ref_by_row_num
 * @property int|null $row_num
 * @property boolean $ref_by_attribute_value
 * @property int|null $dynamic_attribute_id
 * @property string|null $attribute_value
 *
 * @property string|null $description
 *
 * @property Status $status
 * @property DynamicAttribute $dynamicattribute
 */
class LastRowConfigRequest extends FormRequest
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
        return LastRowConfig::defaultRules();
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return LastRowConfig::messagesRules();
    }
}
