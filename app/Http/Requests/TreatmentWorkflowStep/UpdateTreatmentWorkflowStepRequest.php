<?php

namespace App\Http\Requests\TreatmentWorkflowStep;

use App\Enums\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Models\Treatments\TreatmentWorkflow;
use App\Models\Treatments\TreatmentWorkflowStep;

/**
 * Class UpdateTreatmentWorkflowStepRequest
 * @package App\Http\Requests\TreatmentWorkflowStep
 *
 * @property TreatmentWorkflowStep $treatmentworkflowstep
 */
class UpdateTreatmentWorkflowStepRequest extends TreatmentWorkflowStepRequest
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
        return TreatmentWorkflowStep::updateRules($this->treatmentworkflowstep);
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
            'treatmentworkflow' => $this->getRelevantModel(TreatmentWorkflow::class, $this->input('treatmentworkflow'),'id', true),
        ]);
    }
}
