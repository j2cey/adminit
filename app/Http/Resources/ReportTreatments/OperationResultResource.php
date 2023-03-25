<?php

namespace App\Http\Resources\ReportTreatments;

use JsonSerializable;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
 * @property ReportTreatmentStepResult|null $reporttreatmentstepresult
 * @property OperationResult|null $parentoperation
 */
class OperationResultResource extends JsonResource
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
            'operation_no' => $this->operation_no,

            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'operation_duration' => $this->operation_duration,
            'state' => $this->state,
            'message' => $this->message,

            'reporttreatmentstepresult' => $this->reporttreatmentstepresult,
            'parentoperation' => $this->parentoperation,

            'description' => $this->description,
            'created_at' => $this->created_at,

            'show_url' => route('operationresults.show', $this->uuid),
            'edit_url' => route('operationresults.edit', $this->uuid),
            'destroy_url' => route('operationresults.destroy', $this->uuid),
        ];
    }
}
