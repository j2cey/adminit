<?php

namespace App\Http\Requests\DynamicAttribute;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Contracts\DynamicAttribute\IHasDynamicAttributes;

/**
 * Class StoreDynamicAttributeRequest
 * @package App\Http\Requests\DynamicAttribute
 *
 * @property IHasDynamicAttributes $model
 * @property string $model_type
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
        return Auth::user()->can( Permissions::DynamicAttribute()->create() );
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
            'model' => $this->input('model_type')::where('id', $this->input('model_id'))->first(),
            'dynamicattributetype' => $this->setRelevantDynamicAttributeType($this->input('dynamicattributetype')),
            'status' => $this->setRelevantStatus($this->input('status'), "íd", false),

            'searchable' => $this->getCheckValue('searchable'),
            'sortable' => $this->getCheckValue('sortable'),
            'can_be_notified' => $this->getCheckValue('can_be_notified'),
        ]);
    }
}
