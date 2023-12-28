<?php

namespace App\Http\Requests\TreatmentWorkflow;

use App\Enums\Permissions;
use App\Models\Reports\Report;
use Illuminate\Support\Facades\Auth;
use App\Models\Treatments\TreatmentWorkflow;

/**
 * Class UpdateTreatmentWorkflowRequest
 * @package App\Http\Requests\UpdateTreatmentWorkflow
 *
 * @property TreatmentWorkflow $treatmentworkflow
 */
class UpdateTreatmentWorkflowRequest extends TreatmentWorkflowRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can( Permissions::TreatmentWorkflow()->update() );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return TreatmentWorkflow::updateRules($this->treatmentworkflow);
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
