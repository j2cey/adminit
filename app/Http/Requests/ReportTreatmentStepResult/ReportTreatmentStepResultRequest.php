<?php

namespace App\Http\Requests\ReportTreatmentStepResult;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class ReportTreatmentStepResultRequest
 * @package App\Http\Requests\ReportTreatmentStepResult
 *
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property string $state
 * @property string $message
 *
 * @property string $description
 *
 * @property int $report_treatment_result_id
 *
 * @property int $retry_no
 * @property int $retry_session_count
 * @property int $retryof_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property ReportTreatmentResult|null $reporttreatmentresult
 * @property ReportTreatmentStepResult $retryof
 * @property Collection $retries
 */
class ReportTreatmentStepResultRequest extends FormRequest
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
        return ReportTreatmentStepResult::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ReportTreatmentStepResult::messagesRules();
    }
}
