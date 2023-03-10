<?php

namespace App\Http\Requests\ReportFile;

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
        return Auth::user()->can('reportfile-create');
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
            'retrieve_by_name' => $this->getRetrieveByNameNormalized(),
            'retrieve_by_wildcard' => $this->getRetrieveByWildcardNormalized(),
        ]);
    }
}
