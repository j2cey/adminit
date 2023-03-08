<?php

namespace App\Http\Resources;

use App\Models\Status;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StatusResource;

class ReportFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     *
     * * @property integer $id
     *
     * @property string $uuid
     * @property bool $is_default
     * @property integer $created_by
     * @property integer $updated_by
     *
     *
     * @property status $status
     * @property string $name
     * @property string|null $wildcard
     * @property string $retrieve_by_name
     * @property string $retrieve_by_wildcard

     * @property Carbon $created_at
     * @property Carbon $updated_at
     *

     */


    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => StatusResource::make($this->status),

            'name' => $this->name,
            'wildcard' => $this->wildcard,
            'retrieve_by_name' => $this->retrieve_by_name,
            'retrieve_by_wildcard' => $this->retrieve_by_wildcard,

            'created_at' => $this->created_at,

            'show_url' => route('reportfiles.show', $this->uuid),
            'edit_url' => route('reportfiles.edit', $this->uuid),
            'destroy_url' => route('reportfiles.destroy', $this->uuid),
        ];

        //return parent::toArray($request);
    }
}
