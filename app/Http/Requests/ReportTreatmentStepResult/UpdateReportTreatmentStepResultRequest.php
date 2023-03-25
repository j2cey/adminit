<?php

namespace App\Http\Requests\ReportTreatmentStepResult;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class UpdateReportTreatmentStepResultRequest
 * @package App\Http\Requests\ReportTreatmentStepResult
 *
 * @property ReportTreatmentStepResult $reporttreatmentstepresult
 */
class UpdateReportTreatmentStepResultRequest extends ReportTreatmentStepResultRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ReportTreatmentStepResult()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportTreatmentStepResult::updateRules($this->reporttreatmentstepresult);
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
            'reporttreatmentresult' => $this->getRelevantModel(ReportTreatmentResult::class, $this->input('reporttreatmentresult'),'id', true),
            'retryof' => $this->getRelevantModel(ReportTreatmentStepResult::class, $this->input('retryof'),'id', true),
        ]);
    }
}
