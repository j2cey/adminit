<?php

namespace App\Http\Requests\OsArchitecture;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\OsAndServer\OsArchitecture;

/**
 * Class UpdateOsArchitectureRequest
 * @package App\Http\Requests\OsArchitecture
 *
 * @property OsArchitecture $osarchitecture
 */
class UpdateOsArchitectureRequest extends OsArchitectureRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::OsArchitecture()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return OsArchitecture::updateRules($this->osarchitecture);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->setRelevantStatus($this->input('status'),'code', false),
        ]);
    }
}
