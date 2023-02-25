<?php

namespace App\Http\Requests\Report;

use App\Models\Reports\Report;
use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends ReportRequest
{
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
        return Report::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'reporttype' => $this->setRelevantReportType($this->input('reporttype')),
        ]);
    }
}
