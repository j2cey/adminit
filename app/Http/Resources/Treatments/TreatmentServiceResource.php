<?php

namespace App\Http\Resources\Treatments;

use JsonSerializable;
use App\Models\Status;
use App\Enums\QueueEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Treatments\Treatment;
use App\Http\Resources\StatusResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Contracts\ReportTreatment\IServiceActions;

/**
 * Class TreatmentServiceResource
 * @package App\Http\Resources\Treatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property int|null $exec_id
 * @property string|QueueEnum $queue_code
 * @property string|IServiceActions $serviceactions_class
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Treatment $treatment
 * @property Status $status
 */
class TreatmentServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => StatusResource::make($this->status),

            'exec_id' => $this->exec_id,
            'queue_code' => $this->queue_code,

            'serviceactions_class' => $this->serviceactions_class,

            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'show_url' => route('treatmentservices.show', $this->uuid),
            'edit_url' => route('treatmentservices.edit', $this->uuid),
            'destroy_url' => route('treatmentservices.destroy', $this->uuid),
        ];
    }
}
