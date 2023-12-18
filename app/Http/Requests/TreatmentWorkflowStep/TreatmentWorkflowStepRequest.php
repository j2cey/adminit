<?php

namespace App\Http\Requests\TreatmentWorkflowStep;

use App\Models\Status;
use App\Traits\Request\RequestTraits;
use App\Enums\Treatments\TreatmentCodeEnum;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\ReportTreatments\TreatmentWorkflow;
use App\Models\ReportTreatments\TreatmentWorkflowStep;

/**
 * Class TreatmentWorkflowStepRequest
 * @package App\Http\Requests\TreatmentWorkflowStep
 *
 * @property string|TreatmentCodeEnum $code
 * @property string $name
 * @property string $description
 *
 * @property Status $status
 * @property TreatmentWorkflow $treatmentworkflow
 */
class TreatmentWorkflowStepRequest extends FormRequest
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
        return TreatmentWorkflowStep::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return TreatmentWorkflowStep::messagesRules();
    }
}
