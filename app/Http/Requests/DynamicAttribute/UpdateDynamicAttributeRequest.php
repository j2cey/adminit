<?php

namespace App\Http\Requests\DynamicAttribute;

use App\Models\Status;
use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\DynamicAttributes\DynamicAttribute;

/**
 * Class UpdateDynamicAttributeRequest
 * @package App\Http\Requests\DynamicAttribute
 *
 * @property DynamicAttribute $dynamicattribute
 */
class UpdateDynamicAttributeRequest extends DynamicAttributeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::DynamicAttribute()->update() );
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
            'dynamicattributetype' => $this->setRelevantDynamicAttributeType($this->input('dynamicattributetype'), true),
            'status' => $this->getrelevantModelByCode(Status::class, $this->status, true),
        ]);
    }
}
