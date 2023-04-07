<?php

namespace App\Http\Resources\RetrieveAction;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use App\Models\RetrieveAction\RetrieveAction;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class RetrieveActionResource
 * @package App\Http\Resources\RetrieveAction
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 *
 * @property string $code
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property RetrieveAction $retrieveaction
 * @property mixed $retrieveactionvalues
 */
class SelectedRetrieveActionResource extends JsonResource
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
            'name' => $this->retrieveaction->name,

            'status' => StatusResource::make($this->status),
            'retrieveaction' => RetrieveActionResource::make($this->retrieveaction),
            'retrieveactionvalues' => RetrieveActionValueResource::collection($this->retrieveactionvalues),

            'code' => $this->code,
            'description' => $this->description,

            'created_at' => $this->created_at,

            'show_url' => route('selectedretrieveactions.show', $this->uuid),
            'edit_url' => route('selectedretrieveactions.edit', $this->uuid),
            'destroy_url' => route('selectedretrieveactions.destroy', $this->uuid),
        ];
    }
}
