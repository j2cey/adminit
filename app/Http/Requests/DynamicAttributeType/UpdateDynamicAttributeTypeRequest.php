<?php

namespace App\Http\Requests\DynamicAttributeType;

use App\Models\Status;
use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\DynamicAttributes\DynamicAttributeType;

/**
 * Class UpdateDynamicAttributeTypeRequest
 * @package App\Http\Requests\DynamicAttributeType
 *
 * @property DynamicAttributeType $dynamicattributetype
 *
 */
class UpdateDynamicAttributeTypeRequest extends DynamicAttributeTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::DynamicAttributeType()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return DynamicAttributeType::updateRules($this->dynamicattributetype);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->getRelevantModel(Status::class, $this->input('status'),'code', true),
        ]);
    }
}
