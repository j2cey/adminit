<?php

namespace App\Http\Resources\ReportTreatments;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ReportTreatments\ReportTreatmentWorkflow;
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
 * @property string $code
 * @property string $name
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property ReportTreatmentWorkflow $treatmentworkflow
 * @property ReportTreatmentWorkflowStep $previousworkflowstep
 * @property ReportTreatmentWorkflowStep $nextworkflowstep
 */
class ReportTreatmentWorkflowStepResource extends JsonResource
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

            'code' => $this->code,
            'name' => $this->name,

            'treatmentworkflow' => $this->treatmentworkflow,
            'previousworkflowstep' => ReportTreatmentWorkflowStepResource::make($this->previousworkflowstep),
            'nextworkflowstep' => ReportTreatmentWorkflowStepResource::make($this->nextworkflowstep),

            'description' => $this->description,
            'created_at' => $this->created_at,

            'show_url' => route('reporttreatmentworkflowsteps.show', $this->uuid),
            'edit_url' => route('reporttreatmentworkflowsteps.edit', $this->uuid),
            'destroy_url' => route('reporttreatmentworkflowsteps.destroy', $this->uuid),
        ];
    }
}
