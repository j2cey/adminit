<?php

namespace App\Http\Resources\FormatRule;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use App\Models\FormatRule\FormatTextSize;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class FormatTextSizeResource
 * @package App\Http\Resources\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer $format_value
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 */
class FormatTextSizeResource extends JsonResource
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

            'format_value' => $this->format_value,
            'comment' => $this->comment,

            'created_at' => $this->created_at,

            'model_type' => FormatTextSize::class,

            'show_url' => route('formattextsizes.show', $this->uuid),
            'edit_url' => route('formattextsizes.edit', $this->uuid),
            'destroy_url' => route('formattextsizes.destroy', $this->uuid),
        ];
    }
}