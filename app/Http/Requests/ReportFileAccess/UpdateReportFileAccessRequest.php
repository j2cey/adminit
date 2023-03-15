<?php

namespace App\Http\Requests\ReportFileAccess;

use Illuminate\Support\Facades\Auth;
use App\Models\ReportFile\ReportFileAccess;

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
        return Auth::user()->can('reportfileaccess-update');
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
            'reportserver' => $this->setRelevantReportServer($this->input('reportserver'),'id', true),
            'accessprotocole' => $this->setRelevantAccessProtocole($this->input('accessprotocole'),'id', true),
            'status' => $this->setRelevantStatus($this->input('status'),'code', true),
        ]);
    }
}