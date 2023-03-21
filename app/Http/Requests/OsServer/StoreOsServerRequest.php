<?php

namespace App\Http\Requests\OsServer;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\OsAndServer\OsServer;

/**
 * Class StoreOsServerRequest
 * @package App\Http\Requests\OsServer
 *
 *
 */
class StoreOsServerRequest extends OsServerRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::OsServer()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return OsServer::createRules();
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
            'osarchitecture' => $this->setRelevantOsArchitecture($this->input('osarchitecture'),'id', false),
            'osfamily' => $this->setRelevantOsFamily($this->input('osfamily'),'id', false),
        ]);
    }
}
