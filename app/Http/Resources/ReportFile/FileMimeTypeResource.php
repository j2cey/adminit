<?php

namespace App\Http\Resources\ReportFile;

use JsonSerializable;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class StatusResource
 * @package App\Http\Resources
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property string $code
 * @property string $name
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 */
class FileMimeTypeResource extends JsonResource
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

            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,

            'created_at' => $this->created_at,

            'show_url' => route('filemimetypes.show', $this->uuid),
            'edit_url' => route('filemimetypes.edit', $this->uuid),
            'destroy_url' => route('filemimetypes.destroy', $this->uuid),
        ];
    }
}
