<?php

namespace App\Http\Requests\TreatmentWorkflow;

use App\Enums\Permissions;
use App\Models\Reports\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Treatments\TreatmentResult;
use App\Models\Treatments\TreatmentWorkflow;
use App\Models\Treatments\ReportTreatmentStepResult;

/**
 * Class StoreTreatmentWorkflowRequest
 * @package App\Http\Requests\StoreTreatmentWorkflow
 *
 */
class StoreTreatmentWorkflowRequest extends TreatmentWorkflowRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::TreatmentWorkflow()->create() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return TreatmentWorkflow::createRules();
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
        ]);
    }
}
