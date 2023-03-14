<?php

namespace App\Http\Resources\OsAndServer;

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
 * @property string $code
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 */
class OsFamilyResource extends JsonResource
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

            'code' => $this->code,
            'description' => $this->description,

            'created_at' => $this->created_at,

            'show_url' => route('osfamilies.show', $this->uuid),
            'edit_url' => route('osfamilies.edit', $this->uuid),
            'destroy_url' => route('osfamilies.destroy', $this->uuid),
        ];
    }
}
