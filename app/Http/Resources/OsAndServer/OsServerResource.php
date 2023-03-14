<?php

namespace App\Http\Resources\OsAndServer;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Models\OsAndServer\OsFamily;
use App\Http\Resources\StatusResource;
use App\Models\OsAndServer\OsArchitecture;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class OsServerResource
 * @package App\Http\Resources\OsAndServer
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $name
 * @property string|null $description
 *
 * @property integer|null $os_architecture_id
 * @property integer|null $os_family_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property OsArchitecture $osarchitecture
 * @property OsFamily $osfamily
 */
class OsServerResource extends JsonResource
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
            'description' => $this->description,

            'created_at' => $this->created_at,

            'osarchitecture' => OsArchitectureResource::make($this->osarchitecture),
            'osfamily' => OsFamilyResource::make($this->osfamily),

            'show_url' => route('osservers.show', $this->uuid),
            'edit_url' => route('osservers.edit', $this->uuid),
            'destroy_url' => route('osservers.destroy', $this->uuid),
        ];
    }
}
