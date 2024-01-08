<?php

namespace App\Http\Resources\Treatments;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Enums\QueueDispatchMode;
use App\Models\Treatments\Treatment;
use App\Http\Resources\StatusResource;
use App\Enums\Treatments\TreatmentResultEnum;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TreatmentResultResource
 * @package App\Http\Resources\Treatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer $num_ord
 * @property string|TreatmentResultEnum $result
 * @property string|QueueDispatchMode $subs_dispatch_mode
 *
 * @property Carbon|null $start_at
 * @property Carbon|null $last_exec_end_at
 * @property Carbon|null $end_at
 * @property int|null $duration
 * @property string|null $duration_hhmmss
 *
 * @property string $message
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property boolean $isSuccess
 * @property boolean $isFailed
 * @property boolean $isHighCritical
 *
 * @property Treatment $treatment
 * @property Status $status
 */
class TreatmentResultResource extends JsonResource
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

            'num_ord' => $this->num_ord,
            'result' => $this->result,
            'subs_dispatch_mode' => $this->subs_dispatch_mode,

            'start_at' => $this->start_at,
            'last_exec_end_at' => $this->last_exec_end_at,
            'end_at' => $this->end_at,
            'duration' => $this->duration,
            'duration_hhmmss' => $this->duration_hhmmss,

            'message' => $this->message,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'show_url' => route('treatmentresults.show', $this->uuid),
            'edit_url' => route('treatmentresults.edit', $this->uuid),
            'destroy_url' => route('treatmentresults.destroy', $this->uuid),
        ];
    }
}
