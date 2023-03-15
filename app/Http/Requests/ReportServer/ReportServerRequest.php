<?php

namespace App\Http\Requests\ReportServer;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Models\OsAndServer\OsServer;
use App\Traits\Request\RequestTraits;
use App\Models\OsAndServer\ReportServer;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReportServerRequest
 * @package App\Http\Resources\ReportServer
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 *
 * @property string $name
 * @property string $ip_address
 * @property string $domain_name
 * @property string|null $description
 *
 * @property Osserver $osserver
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 *
 * @property Status $status
 */
class ReportServerRequest extends FormRequest
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
        return ReportServer::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ReportServer::messagesRules();
    }
}
