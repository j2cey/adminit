<?php

namespace App\Http\Requests\ReportTreatmentStep;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportTreatments\ReportTreatment;
use App\Models\ReportTreatments\ReportTreatmentStep;

/**
 * Class StoreReportTreatmentStepRequest
 * @package App\Http\Requests\ReportTreatmentStep
 *
 */
class StoreReportTreatmentStepRequest extends ReportTreatmentStepRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ReportTreatmentStep()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportTreatmentStep::createRules();
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
            'reporttreatment' => $this->getRelevantModel(ReportTreatment::class, $this->input('reporttreatment'),'id', false),
            'retryof' => $this->getRelevantModel(ReportTreatmentStep::class, $this->input('retryof'),'id', false),
        ]);
    }
}
