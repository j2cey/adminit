<?php

namespace App\Http\Resources\RetrieveAction;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;
use function route;

/**
 * Class ReportFileTypeResource
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
 */
class RetrieveActionTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => StatusResource::make($this->status),

            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,

            'created_at' => $this->created_at,

            'show_url' => route('retrieveactiontypes.show', $this->uuid),
            'edit_url' => route('retrieveactiontypes.edit', $this->uuid),
            'destroy_url' => route('retrieveactiontypes.destroy', $this->uuid),
        ];
    }
}
