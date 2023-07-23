<?php

namespace App\Http\Requests\ReportTreatmentWorkflowStep;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportTreatments\ReportTreatmentWorkflow;
use App\Models\ReportTreatments\ReportTreatmentWorkflowStep;

/**
 * Class UpdateReportTreatmentWorkflowStepRequest
 * @package App\Http\Requests\ReportTreatmentWorkflowStep
 *
 * @property ReportTreatmentWorkflowStep $reporttreatmentworkflowstep
 */
class UpdateReportTreatmentWorkflowStepRequest extends ReportTreatmentWorkflowStepRequest
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
        return ReportTreatmentWorkflowStep::updateRules($this->reporttreatmentworkflowstep);
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
            'treatmentworkflow' => $this->getRelevantModel(ReportTreatmentWorkflow::class, $this->input('treatmentworkflow'),'id', true),
        ]);
    }
}
