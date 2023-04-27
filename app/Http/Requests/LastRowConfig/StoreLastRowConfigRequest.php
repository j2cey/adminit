<?php

namespace App\Http\Requests\LastRowConfig;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\RowConfig\LastRowConfig;
use App\Contracts\RowConfig\IHasLastRowConfig;

/**
 * Class StoreLastRowConfigRequest
 * @package App\Http\Requests\LastRowConfig
 *
 * @property IHasLastRowConfig $model
 * @property string $model_type
 */
class StoreLastRowConfigRequest extends LastRowConfigRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::LastRowConfig()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return LastRowConfig::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->setRelevantStatus($this->input('status'), "íd", false),
            'model' => $this->input('model_type')::where('id', $this->input('model_id'))->first(),
            'dynamicattribute' => $this->setRelevantDynamicAttribute( $this->input('dynamicattribute'), 'íd', false ),
        ]);
    }
}
