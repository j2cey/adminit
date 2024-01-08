<?php

namespace App\Http\Resources\Treatments;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Treatments\ReportTreatmentStepResult;
use App\Models\Treatments\TreatmentWorkflowStep;

/**
 * Class TreatmentWorkflowResource
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
 * @property TreatmentWorkflowStep $firstworkflowstep
 * @property TreatmentWorkflowStep[] $workflowsteps
 */
class TreatmentWorkflowResource extends JsonResource
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

            'firstworkflowstep' => TreatmentWorkflowStepResource::make($this->firstworkflowstep),
            'workflowsteps' => TreatmentWorkflowStepResource::collection($this->workflowsteps),

            'description' => $this->description,
            'created_at' => $this->created_at,


            'show_url' => route('treatmentworkflows.show', $this->uuid),
            'edit_url' => route('treatmentworkflows.edit', $this->uuid),
            'destroy_url' => route('treatmentworkflows.destroy', $this->uuid),
        ];
    }
}
