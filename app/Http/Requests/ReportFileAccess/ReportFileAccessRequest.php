<?php

namespace App\Http\Requests\ReportFileAccess;

use App\Models\Status;
use App\Models\Access\AccessAccount;
use App\Traits\Request\RequestTraits;
use App\Models\ReportFile\ReportFile;
use App\Models\Access\AccessProtocole;
use App\Models\OsAndServer\ReportServer;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\ReportFile\ReportFileAccess;

/**
 * Class ReportFileAccessRequest
 * @package App\Http\Requests\ReportFileAccess
 *
 * @property string $name
 * @property string|null $code
 * @property string|null $description
 *
 * @property bool $retrieve_by_name
 * @property bool $retrieve_by_wildcard
 *
 *
 * @property Status $status
 * @property AccessAccount $accessaccount
 * @property ReportFile $reportfile
 * @property ReportServer $reportserver
 * @property AccessProtocole $accessprotocole
 */
class ReportFileAccessRequest extends FormRequest
{
    use RequestTraits;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportFileAccess::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return ReportFileAccess::messagesRules();
    }
}
