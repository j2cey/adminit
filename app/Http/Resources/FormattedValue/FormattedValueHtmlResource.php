<?php

namespace App\Http\Resources\FormattedValue;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class FormattedValueHtmlResource
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
 * @property string $thevalue
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 */
class FormattedValueHtmlResource extends JsonResource
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

            'thevalue' => $this->thevalue,
            'comment' => $this->comment,

            'created_at' => $this->created_at,

            'show_url' => route('formattedvaluehtmls.show', $this->uuid),
            'edit_url' => route('formattedvaluehtmls.edit', $this->uuid),
            'destroy_url' => route('formattedvaluehtmls.destroy', $this->uuid),
        ];
    }
}
