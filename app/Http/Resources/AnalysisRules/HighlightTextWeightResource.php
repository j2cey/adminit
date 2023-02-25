<?php

namespace App\Http\Resources\AnalysisRules;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\AnalysisRules\HighlightTextWeight;

/**
 * Class HighlightTextWeightResource
 * @package App\Http\Resources\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $highlight
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class HighlightTextWeightResource extends JsonResource
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

            'model_type' => HighlightTextWeight::class,

            'show_url' => route('highlighttextweights.show', $this->uuid),
            'edit_url' => route('highlighttextweights.edit', $this->uuid),
            'destroy_url' => route('highlighttextweights.destroy', $this->uuid),
        ];
    }
}
