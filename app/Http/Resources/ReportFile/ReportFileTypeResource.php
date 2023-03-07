<?php

namespace App\Http\Resources\ReportFile;

use JsonSerializable;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

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
 * @property string $extension
 * @property string|null $description
 *
 * @property mixed $filemimetype
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 */
class ReportFileTypeResource extends JsonResource
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
            'extension' => $this->extension,
            'description' => $this->description,

            'filemimetype' => FileMimeTypeResource::make($this->filemimetype),

            'created_at' => $this->created_at,

            'show_url' => route('reportfiletypes.show', $this->uuid),
            'edit_url' => route('reportfiletypes.edit', $this->uuid),
            'destroy_url' => route('reportfiletypes.destroy', $this->uuid),
        ];
    }
}
