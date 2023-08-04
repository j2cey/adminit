<?php

namespace App\Http\Requests\ReportTreatmentStep;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ReportTreatments\ReportTreatment;
use App\Models\ReportTreatments\ReportTreatmentStep;

/**
 * Class ReportTreatmentStepRequest
 * @package App\Http\Requests\ReportTreatmentStep
 *
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property string $state
 * @property string $message
 *
 * @property string $description
 *
 * @property int $report_treatment_id
 *
 * @property int $retry_no
 * @property int $retry_session_count
 * @property int $retryof_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property ReportTreatment|null $reporttreatment
 * @property ReportTreatmentStep $retryof
 * @property Collection $retries
 */
class ReportTreatmentStepRequest extends FormRequest
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
        return ReportTreatmentStep::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ReportTreatmentStep::messagesRules();
    }
}
