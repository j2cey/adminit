<?php

namespace App\Http\Requests\DynamicAttribute;

use App\Models\DynamicAttributes\DynamicAttribute;

class UpdateDynamicAttributeRequest extends DynamicAttributeRequest
{
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
        return DynamicAttribute::updateRules($this->dynamicattribute);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'attributetype' => $this->setRelevantDynamicAttributeType($this->input('attributetype'), true),
        ]);
    }
}
