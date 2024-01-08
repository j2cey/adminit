<?php

namespace App\Http\Resources\Treatments;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Enums\CriticalityLevelEnum;
use App\Models\Treatments\Treatment;
use App\Models\ReportFile\ReportFile;
use App\Http\Resources\StatusResource;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Treatments\TreatmentResult;
use App\Enums\Treatments\TreatmentTypeEnum;
use App\Enums\Treatments\TreatmentCodeEnum;
use App\Models\Treatments\TreatmentService;
use App\Enums\Treatments\TreatmentStateEnum;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Contracts\ReportTreatment\ITreatmentType;

/**
 * Class TreatmentResource
 * @package App\Http\Resources\Treatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property string|TreatmentTypeEnum $type
 * @property string|ITreatmentType $treatmenttype_class
 * @property string|TreatmentCodeEnum $code
 * @property integer $level
 * @property integer $exec_id
 * @property string $exectrace
 * @property integer $num_ord
 * @property string|CriticalityLevelEnum $criticality_level
 * @property string|TreatmentStateEnum $prev_state
 * @property string|TreatmentStateEnum $state
 *
 * @property bool $is_last_subtreatment
 * @property bool $can_end_uppertreatment
 * @property bool $all_subtreatments_launched
 * @property bool $all_subtreatments_completed
 * @property bool $dispatch_on_creation
 * @property bool $launch_exec_operation_on_creation
 * @property bool $dispatch_exec_operation_on_creation
 *
 * @property string $payload
 * @property string $innertreatments
 * @property string $description
 *
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property int|null $duration
 * @property string|null $duration_hhmmss
 *
 * @property int $attempts
 * @property Carbon $retry_start_at
 * @property int $retries_session_count
 * @property Carbon $retry_end_at
 *
 * @property int|null $current_stage
 * @property int|null $stages_count
 * $@property string|null $full_path
 *
 * @property int|null $uppertreatment_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property boolean $isHighCritical
 *
 * @method static Builder toProcessOrProcessing()
 * @method static Treatment create(array $array)
 *
 * @property ReportFile $reportfile
 * @property Treatment $uppertreatment
 * @property Treatment $lastestsubtreatment
 * @property Treatment[] $subtreatments
 * @property Treatment[] $subtreatmentswaiting
 * @property TreatmentService $service
 * @property TreatmentResult $treatmentresult
 * @property Status $status
 */
class TreatmentResource extends JsonResource
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
            'type' => $this->type,
            'treatmenttype_class' => $this->treatmenttype_class,
            'code' => $this->code,
            'level' => $this->level,
            'exec_id' => $this->exec_id,
            'exectrace' => $this->exectrace,
            'num_ord' => $this->num_ord,

            'criticality_level' => $this->criticality_level,
            'prev_state' => $this->prev_state,
            'state' => $this->state,

            'is_last_subtreatment' => $this->is_last_subtreatment,
            'can_end_uppertreatment' => $this->can_end_uppertreatment,
            'all_subtreatments_launched' => $this->all_subtreatments_launched,
            'all_subtreatments_completed' => $this->all_subtreatments_completed,
            'dispatch_on_creation' => $this->dispatch_on_creation,
            'launch_exec_operation_on_creation' => $this->launch_exec_operation_on_creation,
            'dispatch_exec_operation_on_creation' => $this->dispatch_exec_operation_on_creation,

            'payload' => $this->payload,
            'innertreatments' => $this->innertreatments,

            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'duration' => $this->duration,
            'duration_hhmmss' => $this->duration_hhmmss,

            'attempts' => $this->attempts,
            'retry_start_at' => $this->retry_start_at,
            'retry_session_count' => $this->retries_session_count,
            'retry_end_at' => $this->retry_end_at,

            'description' => $this->description,
            'created_at' => $this->created_at,

            'reportfile' => $this->reportfile,
            'uppertreatment' => $this->uppertreatment,
            'service' => TreatmentServiceResource::make($this->service),
            'result' => $this->treatmentresult ? $this->treatmentresult->result : 'NULL',
            'treatmentresult' => TreatmentResultResource::make($this->treatmentresult),
            'full_path' => $this->full_path,
            //'subtreatments_count' => $this->subtreatments()->count(),// TreatmentResource::collection($this->subtreatments),

            'show_url' => route('treatments.show', $this->uuid),
            'edit_url' => route('treatments.edit', $this->uuid),
            'destroy_url' => route('treatments.destroy', $this->uuid),
        ];
    }
}
