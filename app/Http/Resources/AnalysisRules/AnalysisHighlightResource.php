<?php

namespace App\Http\Resources\AnalysisRules;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Contracts\Support\Arrayable;
use App\Models\AnalysisRules\AnalysisHighlight;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AnalysisHighlightResource
 * @package App\Http\Resources\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $title
 * @property string $description
 *
 * @property string $when_rule_result_is
 * @property integer|null $analysis_rule_id
 *
 * @property string|null $innerhighlight_type
 * @property string|null $innerhighlight_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AnalysisHighlightResource extends JsonResource
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

            'title' => $this->title,
            'description' => $this->description,

            'highlighttype' => AnalysisHighlightTypeResource::make($this->highlighttype),

            'innerhighlight' => $this->innerhighlight,

            'innerhighlight_type' => $this->innerhighlight_type,
            'innerhighlight_id' => $this->innerhighlight_id,

            'when_rule_result_is' => $this->when_rule_result_is,
            'analysis_rule_id' => $this->analysis_rule_id,

            'model_type' => AnalysisHighlight::class,

            'created_at' => $this->created_at,

            'show_url' => route('analysisruletypes.show', $this->uuid),
            'edit_url' => route('analysisruletypes.edit', $this->uuid),
            'destroy_url' => route('analysisruletypes.destroy', $this->uuid),
        ];
    }
}
