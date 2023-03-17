<?php

namespace App\Http\Resources\ReportFile;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use App\Models\ReportFile\RetrieveActionType;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class RetrieveActionResource
 * @package App\Http\Resources\ReportFile
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 *
 * @property string $name
 * @property string $code
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property RetrieveActionType $retrieveactiontype
 */
class RetrieveActionResource extends JsonResource
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
            'retrieveactiontype' => RetrieveActionTypeResource::make($this->retrieveactiontype),

            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,

            'created_at' => $this->created_at,

            'show_url' => route('retrieveactions.show', $this->uuid),
            'edit_url' => route('retrieveactions.edit', $this->uuid),
            'destroy_url' => route('retrieveactions.destroy', $this->uuid),
        ];
    }
}
