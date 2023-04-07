<?php

namespace App\Http\Resources\FormattedValue;

use JsonSerializable;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use App\Models\FormattedValue\FormatType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Contracts\FormattedValue\IInnerFormattedValue;

/**
 * Class FormattedValueResource
 * @package App\Http\Resources\FormattedValue
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 *
 * @property string $title
 * @property string|null $header
 * @property string|null $body
 * @property string|null $footer
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property FormatType $formattype
 * @property IInnerFormattedValue $innerformattedvalue
 *
 * @property Status $status
 */
class FormattedValueResource extends JsonResource
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

            'formattype' => FormatTypeResource::make($this->formattype),

            'title' => $this->title,
            'header' => $this->header,
            'body' => $this->body,
            'footer' => $this->footer,

            'description' => $this->description,
            'innerformattedvalue' => $this->innerformattedvalue,

            'created_at' => $this->created_at,

            'show_url' => route('formattedvalues.show', $this->uuid),
            'edit_url' => route('formattedvalues.edit', $this->uuid),
            'destroy_url' => route('formattedvalues.destroy', $this->uuid),
        ];
    }
}
