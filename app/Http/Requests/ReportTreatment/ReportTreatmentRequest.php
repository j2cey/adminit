<?php

namespace App\Http\Requests\ReportTreatment;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\ReportTreatments\ReportTreatment;
use App\Models\ReportTreatments\ReportTreatmentStep;

/**
 * Class ReportTreatmentRequest
 * @package App\Http\Requests\ReportTreatment
 *
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property string $state
 *
 * @property string $description
 *
 * @property int $currentstep_num
 * @property int $currentstep_id
 * @property int $report_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property Report $report
 * @property ReportTreatmentStep $currentstep
 */
class ReportTreatmentRequest extends FormRequest
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
        return ReportTreatment::defaultRules();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return ReportTreatment::messagesRules();
    }
}
