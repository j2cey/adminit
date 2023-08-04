<?php

namespace App\Http\Requests\ReportTreatment;

use App\Enums\Permissions;
use App\Models\Reports\Report;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportTreatments\ReportTreatment;
use App\Models\ReportTreatments\ReportTreatmentStep;

/**
 * Class StoreReportTreatmentRequest
 * @package App\Http\Requests\ReportTreatment
 *
 */
class StoreReportTreatmentRequest extends ReportTreatmentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::ReportTreatment()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportTreatment::createRules();
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
            'currentstep' => $this->getRelevantModel(ReportTreatmentStep::class, $this->input('currentstep'),'id', false),
        ]);
    }
}
