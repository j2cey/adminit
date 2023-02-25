<?php

namespace App\Http\Resources\AnalysisRules;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Contracts\Support\Arrayable;
use App\Models\AnalysisRules\HighlightTextSize;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class HighlightTextSizeResource
 * @package App\Http\Resources\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer $highlight
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class HighlightTextSizeResource extends JsonResource
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

            'highlight' => $this->highlight,
            'comment' => $this->comment,

            'created_at' => $this->created_at,

            'model_type' => HighlightTextSize::class,

            'show_url' => route('highlighttextsizes.show', $this->uuid),
            'edit_url' => route('highlighttextsizes.edit', $this->uuid),
            'destroy_url' => route('highlighttextsizes.destroy', $this->uuid),
        ];
    }
}
