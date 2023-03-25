<?php

namespace App\Http\Requests\ReportTreatmentResult;

use App\Enums\Permissions;
use App\Models\Reports\Report;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class UpdateReportTreatmentResultRequest
 * @package App\Http\Requests\ReportTreatmentResult
 *
 * @property ReportTreatmentResult $reporttreatmentresult
 */
class UpdateReportTreatmentResultRequest extends ReportTreatmentResultRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ReportTreatmentResult()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportTreatmentResult::updateRules($this->reporttreatmentresult);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->setRelevantStatus($this->input('status'),'code', true),
            'report' => $this->getRelevantModel(Report::class, $this->input('report'),'id', true),
            'currentstep' => $this->getRelevantModel(ReportTreatmentStepResult::class, $this->input('currentstep'),'id', true),
        ]);
    }
}
