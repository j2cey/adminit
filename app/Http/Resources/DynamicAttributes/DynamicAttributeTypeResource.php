<?php

namespace App\Http\Resources\DynamicAttributes;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DynamicAttributeTypeResource
 * @package App\Http\Resources\DynamicAttributes
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property string $model_type
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class DynamicAttributeTypeResource extends JsonResource
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

            'name' => $this->name,
            'model_type' => $this->model_type,
            'description' => $this->description,

            'created_at' => $this->created_at,

            'show_url' => route('dynamicattributetypes.show', $this->uuid),
            'edit_url' => route('dynamicattributetypes.edit', $this->uuid),
            'destroy_url' => route('dynamicattributetypes.destroy', $this->uuid),
        ];
    }
}
