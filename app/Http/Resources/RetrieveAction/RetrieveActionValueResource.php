<?php

namespace App\Http\Resources\RetrieveAction;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\RetrieveAction\SelectedRetrieveAction;

/**
 * Class RetrieveActionValueResource
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
 * @property string $label
 * @property string $type
 * @property string $value_string
 * @property int $value_int
 * @property Carbon $value_datetime
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property SelectedRetrieveAction $selectedretrieveaction
 */
class RetrieveActionValueResource extends JsonResource
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
            'selectedretrieveaction' => $this->selectedretrieveaction,

            'label' => $this->label,
            'type' => $this->type,
            'value_string' => $this->value_string,
            'value_int' => $this->value_int,
            'value_datetime' => $this->value_datetime,

            'description' => $this->description,
            'created_at' => $this->created_at,

            'show_url' => route('retrieveactionvalues.show', $this->uuid),
            'edit_url' => route('retrieveactionvalues.edit', $this->uuid),
            'destroy_url' => route('retrieveactionvalues.destroy', $this->uuid),
        ];
    }
}
