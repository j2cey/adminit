<?php

namespace App\Http\Resources\ReportTreatments;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ReportTreatments\ReportTreatmentStepResult;
use App\Models\ReportTreatments\ReportTreatmentWorkflowStep;

/**
 * Class ReportTreatmentWorkflowResource
 * @package App\Http\Resources\ReportTreatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property Report $report
 * @property ReportTreatmentWorkflowStep $firstworkflowstep
 * @property ReportTreatmentWorkflowStep[] $workflowsteps
 */
class ReportTreatmentWorkflowResource extends JsonResource
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

            'firstworkflowstep' => ReportTreatmentWorkflowStepResource::make($this->firstworkflowstep),
            'workflowsteps' => ReportTreatmentWorkflowStepResource::collection($this->workflowsteps),

            'description' => $this->description,
            'created_at' => $this->created_at,


            'show_url' => route('reporttreatmentworkflows.show', $this->uuid),
            'edit_url' => route('reporttreatmentworkflows.edit', $this->uuid),
            'destroy_url' => route('reporttreatmentworkflows.destroy', $this->uuid),
        ];
    }
}
