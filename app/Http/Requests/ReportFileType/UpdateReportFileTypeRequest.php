<?php

namespace App\Http\Requests\ReportFileType;

use Illuminate\Support\Facades\Auth;
use App\Models\ReportFile\ReportFileType;

class UpdateReportFileTypeRequest extends ReportFileTypeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('reportfiletype-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ReportFileType::updateRules($this->reportfiletype);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'filemimetype' => $this->setRelevantFileMimeType($this->input('filemimetype'),'id', true),
        ]);
    }
}
