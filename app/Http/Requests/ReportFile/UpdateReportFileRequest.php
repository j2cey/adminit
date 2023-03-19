<?php

namespace App\Http\Requests\ReportFile;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportFile\ReportFile;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReportFileRequest extends ReportFileRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ReportFile()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ReportFile::updateRules($this->reportfile);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'report' => $this->setRelevantReport($this->input('report'),'id', true),
            'reportfiletype' => $this->setRelevantReportFileType($this->input('reportfiletype'),'id', true),
            'status' => $this->setRelevantStatus($this->input('status'),'code', true),
            'retrieve_by_name' => ReportFileRequest::getRetrieveTypeNormalized($this->input('retrieve_by_name')),
            'retrieve_by_wildcard' => ReportFileRequest::getRetrieveTypeNormalized($this->input('retrieve_by_wildcard')),
        ]);
    }
}
