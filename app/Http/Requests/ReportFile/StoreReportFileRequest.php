<?php

namespace App\Http\Requests\ReportFile;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportFile\ReportFile;

class StoreReportFileRequest extends ReportFileRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ReportFile()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ReportFile::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'report' => $this->setRelevantReport($this->input('report'),'id', false),
            'reportfiletype' => $this->setRelevantReportFileType($this->input('reportfiletype'),'id', false),
            'status' => $this->setRelevantStatus($this->input('status'),'code', false),
            'retrieve_by_name' => ReportFileRequest::getRetrieveTypeNormalized($this->input('retrieve_by_name')),
            'retrieve_by_wildcard' => ReportFileRequest::getRetrieveTypeNormalized($this->input('retrieve_by_wildcard')),
        ]);
    }
}
