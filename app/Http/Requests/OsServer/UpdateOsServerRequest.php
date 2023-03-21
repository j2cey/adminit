<?php

namespace App\Http\Requests\OsServer;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\OsAndServer\OsServer;

/**
 * Class UpdateOsServerRequest
 * @package App\Http\Requests\OsServer
 *
 * @property OsServer $osserver
 */
class UpdateOsServerRequest extends OsServerRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::OsServer()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return OsServer::updateRules($this->osserver);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->setRelevantStatus($this->input('status'),'code', true),
            'osarchitecture' => $this->setRelevantOsArchitecture($this->input('osarchitecture'),'id', true),
            'osfamily' => $this->setRelevantOsFamily($this->input('osfamily'),'id', true),
        ]);
    }
}
