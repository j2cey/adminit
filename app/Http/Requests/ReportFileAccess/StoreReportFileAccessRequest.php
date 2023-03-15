<?php

namespace App\Http\Requests\ReportFileAccess;

use Illuminate\Support\Facades\Auth;
use App\Models\ReportFile\ReportFileAccess;

/**
 * Class StoreReportFileAccessRequest
 * @package App\Http\Requests\ReportFileAccess
 *
 *
 */
class StoreReportFileAccessRequest extends ReportFileAccessRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::user()->can('reportfileaccess-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportFileAccess::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'reportfile' => $this->setRelevantReportFile($this->input('reportfile'),'id', false),
            'reportserver' => $this->setRelevantReportServer($this->input('reportserver'),'id', false),
            'accessprotocole' => $this->setRelevantAccessProtocole($this->input('accessprotocole'),'id', false),
            'status' => $this->setRelevantStatus($this->input('status'),'code', false),
        ]);
    }
}
