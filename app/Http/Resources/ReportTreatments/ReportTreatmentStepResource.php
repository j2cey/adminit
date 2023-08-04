<?php

namespace App\Http\Resources\ReportTreatments;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ReportTreatments\OperationResult;
use App\Models\ReportTreatments\ReportTreatment;

/**
 * Class ReportTreatmentStepResource
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
 * @property integer $attempts
 * @property string $payload
 *
 * @property string $description
 *
 * @property int $report_treatment_id
 *
 * @property Carbon $retry_start_at
 * @property int $retries_session_count
 * @property Carbon $retry_end_at
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string|null $hasreporttreatmentsteps_type
 * @property int|null $hasreporttreatmentsteps_id
 *
 * @property Status $status
 * @property ReportTreatment|null $reporttreatment
 *
 * @property OperationResult[] $operationresults
 * @property OperationResult $latestOperationresult
 */
class ReportTreatmentStepResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => StatusResource::make($this->status),

            'name' => $this->name,
            'reporttreatment' => $this->reporttreatment,

            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'result' => $this->result,
            'state' => $this->state,
            'message' => $this->message,
            'attempts' => $this->attempts,
            'payload' => $this->payload,

            'retry_start_at' => $this->retry_start_at,
            'retry_session_count' => $this->retries_session_count,
            'retry_end_at' => $this->retry_end_at,

            'latestOperationresult' => OperationResultResource::make($this->latestOperationresult),
            'operationresults' => OperationResultResource::collection($this->operationresults),

            'hasreporttreatmentsteps_type' => $this->hasreporttreatmentsteps_type,
            'hasreporttreatmentsteps_id' => $this->hasreporttreatmentsteps_id,

            'description' => $this->description,
            'created_at' => $this->created_at,

            'show_url' => route('reporttreatmentsteps.show', $this->uuid),
            'edit_url' => route('reporttreatmentsteps.edit', $this->uuid),
            'destroy_url' => route('reporttreatmentsteps.destroy', $this->uuid),
        ];
    }
}
