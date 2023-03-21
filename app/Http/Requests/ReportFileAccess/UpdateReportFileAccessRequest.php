<?php

namespace App\Http\Requests\ReportFileAccess;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportFile\ReportFileAccess;
use App\Http\Requests\ReportFile\ReportFileRequest;

/**
 * Class UpdateReportFileAccessRequest
 * @package App\Http\Requests\ReportFileAccess
 *
 * @property ReportFileAccess $reportfileaccess
 */
class UpdateReportFileAccessRequest extends ReportFileAccessRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->can( Permissions::ReportFileAccess()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportFileAccess::updateRules($this->reportfileaccess);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'reportfile' => $this->setRelevantReportFile($this->input('reportfile'),'id', true),
            'accessaccount' => $this->setRelevantAccessAccount($this->input('accessaccount'),'id', true),
            'reportserver' => $this->setRelevantReportServer($this->input('reportserver'),'id', true),
            'accessprotocole' => $this->setRelevantAccessProtocole($this->input('accessprotocole'),'id', true),
            'status' => $this->setRelevantStatus($this->input('status'),'code', true),

            'retrieve_by_name' => ReportFileRequest::getRetrieveTypeNormalized($this->input('retrieve_by_name')),
            'retrieve_by_wildcard' => ReportFileRequest::getRetrieveTypeNormalized($this->input('retrieve_by_wildcard')),
        ]);
    }
}
