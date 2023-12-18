<?php

namespace App\Http\Requests\TreatmentWorkflow;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\ReportTreatments\TreatmentWorkflow;

/**
 * Class TreatmentWorkflowRequest
 * @package App\Http\Requests\TreatmentWorkflow
 *
 * @property string $name
 * @property string $description
 *
 * @property Status $status
 * @property Report $report
 */
class TreatmentWorkflowRequest extends FormRequest
{
    use RequestTraits;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return TreatmentWorkflow::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return TreatmentWorkflow::messagesRules();
    }
}
