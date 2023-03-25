<?php

namespace App\Http\Requests\ReportTreatmentResult;

use App\Enums\Permissions;
use App\Models\Reports\Report;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class StoreReportTreatmentResultRequest
 * @package App\Http\Requests\ReportTreatmentResult
 *
 */
class StoreReportTreatmentResultRequest extends ReportTreatmentResultRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ReportTreatmentResult()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportTreatmentResult::createRules();
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
            'report' => $this->getRelevantModel(Report::class, $this->input('report'),'id', false),
            'currentstep' => $this->getRelevantModel(ReportTreatmentStepResult::class, $this->input('currentstep'),'id', false),
        ]);
    }
}