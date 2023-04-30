<?php

namespace App\Http\Resources\ReportTreatments;

use JsonSerializable;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Http\Resources\StatusResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ReportTreatments\OperationResult;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class ReportTreatmentStepResultResource
 * @package App\Http\Resources\ReportTreatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property string $result
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
 * @property string|null $hasreporttreatmentstepresults_type
 * @property int|null $hasreporttreatmentstepresults_id
 *
 * @property Status $status
 * @property ReportTreatmentResult|null $reporttreatmentresult
 * @property ReportTreatmentStepResult $retryof
 * @property ReportTreatmentStepResult[] $retries
 *
 * @property OperationResult[] $operationresults
 * @property OperationResult $latestOperationresult
 */
class ReportTreatmentStepResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => StatusResource::make($this->status),

            'name' => $this->name,
            'reporttreatmentresult' => $this->reporttreatmentresult,

            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'result' => $this->result,
            'state' => $this->state,
            'message' => $this->message,

            'retry_no' => $this->retry_no,
            'retry_session_count' => $this->retry_session_count,
            'retryof' => $this->retryof,
            'retries' => $this->retries,

            'latestOperationresult' => OperationResultResource::make($this->latestOperationresult),
            'operationresults' => OperationResultResource::collection($this->operationresults),

            'hasreporttreatmentstepresults_type' => $this->hasreporttreatmentstepresults_type,
            'hasreporttreatmentstepresults_id' => $this->hasreporttreatmentstepresults_id,

            'description' => $this->description,
            'created_at' => $this->created_at,

            'show_url' => route('reporttreatmentstepresults.show', $this->uuid),
            'edit_url' => route('reporttreatmentstepresults.edit', $this->uuid),
            'destroy_url' => route('reporttreatmentstepresults.destroy', $this->uuid),
        ];
    }
}
