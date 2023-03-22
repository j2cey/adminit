<?php

namespace App\Http\Requests\DynamicAttributeType;

use App\Models\Status;
use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\DynamicAttributes\DynamicAttributeType;

/**
 * Class DynamicAttributeTypeRequest
 * @package App\Http\Requests\DynamicAttributeType
 *
 */
class StoreDynamicAttributeTypeRequest extends DynamicAttributeTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::DynamicAttributeType()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return DynamicAttributeType::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->getRelevantModel(Status::class, $this->input('status'),'code', false),
        ]);
    }
}
