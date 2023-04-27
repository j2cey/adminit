<?php

namespace App\Http\Requests\LastRowConfig;

use App\Models\Status;
use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\RowConfig\LastRowConfig;

/**
 * Class UpdateLastRowConfigRequest
 * @package App\Http\Requests\LastRowConfig
 *
 * @property LastRowConfig $lastrowconfig
 */
class UpdateLastRowConfigRequest extends LastRowConfigRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::LastRowConfig()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return LastRowConfig::updateRules($this->lastrowconfig);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->getrelevantModelByCode(Status::class, $this->status, true),
            'dynamicattribute' => $this->setRelevantDynamicAttribute( $this->input('dynamicattribute'), 'íd', true ),
        ]);
    }
}
