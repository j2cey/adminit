<?php

namespace App\Http\Requests\ReportTreatmentWorkflowStep;

use App\Models\Status;
use App\Enums\TreatmentStepCode;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\ReportTreatments\ReportTreatmentWorkflow;
use App\Models\ReportTreatments\ReportTreatmentWorkflowStep;

/**
 * Class ReportTreatmentWorkflowStepRequest
 * @package App\Http\Requests\ReportTreatmentWorkflowStep
 *
 * @property TreatmentStepCode $code
 * @property string $name
 * @property string $description
 *
 * @property Status $status
 * @property ReportTreatmentWorkflow $treatmentworkflow
 */
class ReportTreatmentWorkflowStepRequest extends FormRequest
{
    use RequestTraits;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportTreatmentWorkflowStep::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ReportTreatmentWorkflowStep::messagesRules();
    }
}
