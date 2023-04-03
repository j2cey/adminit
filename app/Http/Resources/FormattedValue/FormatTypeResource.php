<?php

namespace App\Http\Resources\FormattedValue;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use App\Models\RetrieveAction\RetrieveAction;
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
 * @property string $code
 * @property string $formattype_class
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property RetrieveAction[] $retrieveactions
 */
class FormatTypeResource extends JsonResource
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

            'name' => $this->name,
            'code' => $this->code,
            'formattype_class' => $this->formattype_class,
            'description' => $this->description,

            'created_at' => $this->created_at,

            'show_url' => route('formattypes.show', $this->uuid),
            'edit_url' => route('formattypes.edit', $this->uuid),
            'destroy_url' => route('formattypes.destroy', $this->uuid),
        ];
    }
}
