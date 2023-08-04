<?php

namespace App\Http\Requests\ReportTreatmentStep;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportTreatments\ReportTreatment;
use App\Models\ReportTreatments\ReportTreatmentStep;

/**
 * Class UpdateReportTreatmentStepRequest
 * @package App\Http\Requests\ReportTreatmentStep
 *
 * @property ReportTreatmentStep $reporttreatmentstep
 */
class UpdateReportTreatmentStepRequest extends ReportTreatmentStepRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ReportTreatmentStep()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportTreatmentStep::updateRules($this->reporttreatmentstep);
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
            'reporttreatment' => $this->getRelevantModel(ReportTreatment::class, $this->input('reporttreatment'),'id', true),
            'retryof' => $this->getRelevantModel(ReportTreatmentStep::class, $this->input('retryof'),'id', true),
        ]);
    }
}
