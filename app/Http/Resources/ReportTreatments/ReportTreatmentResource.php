<?php

namespace App\Http\Resources\ReportTreatments;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ReportTreatments\ReportTreatmentStep;

/**
 * Class ReportTreatmentResource
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
 * @property string $state
 * @property string $result
 * @property string $message
 * @property int $attempts
 * @property string $payload
 *
 * @property string $description
 *
 * @property Carbon $retry_start_at
 * @property int $retries_session_count
 * @property Carbon $retry_end_at
 *
 * @property int $currentstep_num
 * @property int $currentstep_id
 * @property int $report_id
 *
 * @property string|null $hasreporttreatments_type
 * @property int|null $hasreporttreatments_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property integer $stepsWaitingCount
 * @property integer $stepsQueuedCount
 * @property integer $stepsRunningCount
 * @property integer $stepsRetryingCount
 * @property integer $stepsSuccessCount
 * @property integer $stepsFailedCount
 *
 * @property Status $status
 * @property Report $report
 * @property ReportTreatmentStep[] $reporttreatmentsteps
 * @property ReportTreatmentStep $currentstep
 */
class ReportTreatmentResource extends JsonResource
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
            'report' => $this->report,

            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'state' => $this->state,
            'result' => $this->result,
            'message' => $this->message,
            'attempts' => $this->attempts,
            'payload' => $this->payload,

            'retry_start_at' => $this->retry_start_at,
            'retry_session_count' => $this->retries_session_count,
            'retry_end_at' => $this->retry_end_at,

            'reporttreatmentsteps' => ReportTreatmentStepResource::collection($this->reporttreatmentsteps),

            'currentstep_num' => $this->currentstep_num,
            'currentstep' => $this->currentstep,
            'hasreporttreatments_type' => $this->hasreporttreatments_type,
            'hasreporttreatments_id' => $this->hasreporttreatments_id,

            'description' => $this->description,
            'created_at' => $this->created_at,

            'stepsWaitingCount' => $this->stepsWaitingCount,
            'stepsQueuedCount' => $this->stepsQueuedCount,
            'stepsRunningCount' => $this->stepsRunningCount,
            'stepsRetryingCount' => $this->stepsRetryingCount,
            'stepsSuccessCount' => $this->stepsSuccessCount,
            'stepsFailedCount' => $this->stepsFailedCount,

            'show_url' => route('reporttreatments.show', $this->uuid),
            'edit_url' => route('reporttreatments.edit', $this->uuid),
            'destroy_url' => route('reporttreatments.destroy', $this->uuid),
        ];
    }
}
