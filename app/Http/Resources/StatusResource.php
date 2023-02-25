<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
 * @property string $style
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'is_default' => $this->is_default,
            'tags' => $this->tags,
            'code' => $this->code,
            'name' => $this->name,
            'style' => $this->style,

            'created_at' => $this->created_at,
        ];
    }
}
