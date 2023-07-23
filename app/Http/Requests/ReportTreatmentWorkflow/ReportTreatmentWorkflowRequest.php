<?php

namespace App\Http\Requests\ReportTreatmentWorkflow;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\ReportTreatments\ReportTreatmentWorkflow;

/**
 * Class ReportTreatmentWorkflowRequest
 * @package App\Http\Requests\ReportTreatmentWorkflow
 *
 * @property string $name
 * @property string $description
 *
 * @property Status $status
 * @property Report $report
 */
class ReportTreatmentWorkflowRequest extends FormRequest
{
    use RequestTraits;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ReportTreatmentWorkflow::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ReportTreatmentWorkflow::messagesRules();
    }
}
