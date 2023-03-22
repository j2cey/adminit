<?php

namespace App\Http\Requests\DynamicAttributeType;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\DynamicAttributes\DynamicAttributeType;

/**
 * Class DynamicAttributeTypeRequest
 * @package App\Http\Requests\DynamicAttributeType
 *
 * @property string $name
 * @property string $code
 * @property string $model_type
 * @property string|null $description
 *
 * @property Status $status
 */
class DynamicAttributeTypeRequest extends FormRequest
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
    public function rules(): array
    {
        return DynamicAttributeType::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return DynamicAttributeType::messagesRules();
    }
}
