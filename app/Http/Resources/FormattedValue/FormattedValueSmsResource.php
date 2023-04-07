<?php

namespace App\Http\Resources\FormattedValue;

use JsonSerializable;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class FormattedValueSmsResource
 * @package App\Http\Resources\FormattedValue
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 */
class FormattedValueSmsResource extends JsonResource
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
            'status' => StatusResource::make($this->status),

            'comment' => $this->comment,

            'created_at' => $this->created_at,

            'show_url' => route('formattedvaluesms.show', $this->uuid),
            'edit_url' => route('formattedvaluesms.edit', $this->uuid),
            'destroy_url' => route('formattedvaluesms.destroy', $this->uuid),
        ];
    }
}
