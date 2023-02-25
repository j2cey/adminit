<?php

namespace App\Http\Requests\DynamicAttribute;

use App\Models\DynamicAttributes\DynamicAttribute;

/**
 * Class StoreDynamicAttributeRequest
 * @package App\Http\Requests\DynamicAttribute
 *
 * @property mixed $model
 */
class StoreDynamicAttributeRequest extends DynamicAttributeRequest
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
        return DynamicAttribute::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'model' => $this->input('model_type')::find($this->input('model_id'))->first(),
            'attributetype' => $this->setRelevantDynamicAttributeType($this->input('attributetype')),
        ]);
    }
}
