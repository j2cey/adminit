<?php

namespace App\Http\Requests\TreatmentOperation;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\ReportTreatments\OperationResult;
use App\Models\ReportTreatments\TreatmentOperation;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class TreatmentOperationRequest
 * @package App\Http\Requests\StoreTreatmentOperation
 *
 * @property string $name
 * @property int $operation_no
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property int $operation_duration
 * @property string $state
 * @property string $message
 *
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property int|null $report_treatment_step_result_id
 * @property int|null $parent_operation_id
 *
 * @property Status $status
 * @property ReportTreatmentStepResult|null $reporttreatmentstepresult
 * @property OperationResult|null $parentoperation
 */
class TreatmentOperationRequest extends FormRequest
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
        return TreatmentOperation::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return TreatmentOperation::messagesRules();
    }
}
