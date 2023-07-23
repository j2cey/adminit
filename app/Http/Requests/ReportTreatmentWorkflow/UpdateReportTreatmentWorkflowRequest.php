<?php

namespace App\Http\Requests\ReportTreatmentWorkflow;

use App\Enums\Permissions;
use App\Models\Reports\Report;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportTreatments\ReportTreatmentWorkflow;

/**
 * Class UpdateReportTreatmentWorkflowRequest
 * @package App\Http\Requests\UpdateReportTreatmentWorkflow
 *
 * @property ReportTreatmentWorkflow $reporttreatmentworkflow
 */
class UpdateReportTreatmentWorkflowRequest extends ReportTreatmentWorkflowRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ReportTreatmentWorkflow()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportTreatmentWorkflow::updateRules($this->reporttreatmentworkflow);
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
        ]);
    }
}
