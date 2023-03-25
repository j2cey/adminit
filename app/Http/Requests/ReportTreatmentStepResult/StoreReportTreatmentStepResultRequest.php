<?php

namespace App\Http\Requests\ReportTreatmentStepResult;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class StoreReportTreatmentStepResultRequest
 * @package App\Http\Requests\ReportTreatmentStepResult
 *
 */
class StoreReportTreatmentStepResultRequest extends ReportTreatmentStepResultRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ReportTreatmentStepResult()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportTreatmentStepResult::createRules();
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
            'reporttreatmentresult' => $this->getRelevantModel(ReportTreatmentResult::class, $this->input('reporttreatmentresult'),'id', false),
            'retryof' => $this->getRelevantModel(ReportTreatmentStepResult::class, $this->input('retryof'),'id', false),
        ]);
    }
}
