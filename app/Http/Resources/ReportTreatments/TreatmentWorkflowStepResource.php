<?php

namespace App\Http\Resources\ReportTreatments;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Treatments\TreatmentWorkflow;
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
 * @property string $code
 * @property string $name
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property TreatmentWorkflow $treatmentworkflow
 * @property TreatmentWorkflowStep $previousworkflowstep
 * @property TreatmentWorkflowStep $nextworkflowstep
 */
class TreatmentWorkflowStepResource extends JsonResource
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
            'previousworkflowstep' => TreatmentWorkflowStepResource::make($this->previousworkflowstep),
            'nextworkflowstep' => TreatmentWorkflowStepResource::make($this->nextworkflowstep),

            'description' => $this->description,
            'created_at' => $this->created_at,

            'show_url' => route('treatmentworkflowsteps.show', $this->uuid),
            'edit_url' => route('treatmentworkflowsteps.edit', $this->uuid),
            'destroy_url' => route('treatmentworkflowsteps.destroy', $this->uuid),
        ];
    }
}
