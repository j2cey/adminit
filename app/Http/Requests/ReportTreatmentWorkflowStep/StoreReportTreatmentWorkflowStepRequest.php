<?php

namespace App\Http\Requests\ReportTreatmentWorkflowStep;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportTreatments\ReportTreatmentWorkflow;
use App\Models\ReportTreatments\ReportTreatmentWorkflowStep;

/**
 * Class StoreReportTreatmentWorkflowStepRequest
 * @package App\Http\Requests\ReportTreatmentWorkflowStep
 *
 */
class StoreReportTreatmentWorkflowStepRequest extends ReportTreatmentWorkflowStepRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ReportTreatmentWorkflowStep()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportTreatmentWorkflowStep::createRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->setRelevantStatus($this->input('status'),'code', false),
            'treatmentworkflow' => $this->getRelevantModel(ReportTreatmentWorkflow::class, $this->input('treatmentworkflow'),'id', false),
        ]);
    }
}
