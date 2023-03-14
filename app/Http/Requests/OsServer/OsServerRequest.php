<?php

namespace App\Http\Requests\OsServer;

use App\Models\Status;
use App\Models\OsAndServer\OsFamily;
use App\Models\OsAndServer\OsServer;
use App\Traits\Request\RequestTraits;
use App\Models\OsAndServer\OsArchitecture;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class OsServerRequest
 * @package App\Http\Requests\OsServer
 *
 * @property string $name
 * @property string|null $description
 *
 * @property OsArchitecture $osarchitecture
 * @property OsFamily $osfamily
 *
 * @property Status $status
 */
class OsServerRequest extends FormRequest
{
    use RequestTraits;
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
        return OsServer::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return OsServer::messagesRules();
    }
}
