<?php

namespace App\Http\Resources\AnalysisRules;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use App\Models\AnalysisRules\AnalysisRule;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AnalysisRuleResource
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
 * @property string $innerrule_type
 * @property integer $innerrule_id
 *
 * @property boolean $alert_when_allowed
 * @property boolean $alert_when_broken
 *
 * @property integer|null $analysis_rule_type_id
 * @property integer|null $dynamic_attribute_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AnalysisRuleResource extends JsonResource
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

            'alert_when_allowed' => $this->alert_when_allowed,
            'alert_when_broken' => $this->alert_when_broken,

            'innerrule_type' => $this->innerrule_type,
            'innerrule_id' => $this->innerrule_id,
            'analysisruletype' => AnalysisRuleTypeResource::make($this->analysisruletype),
            'innerrule' => $this->innerrule,

            'dynamic_attribute_id' => $this->dynamic_attribute_id,
            'model_type' => AnalysisRule::class,

            //'highlights' => AnalysisHighlightResource::collection($this->highlights),
            'whenallowedhighlights' => AnalysisHighlightResource::collection($this->whenallowedhighlights),
            'whenbrokenhighlights' => AnalysisHighlightResource::collection($this->whenbrokenhighlights),

            'created_at' => $this->created_at,

            'show_url' => route('analysisruletypes.show', $this->uuid),
            'edit_url' => route('analysisruletypes.edit', $this->uuid),
            'destroy_url' => route('analysisruletypes.destroy', $this->uuid),
        ];
    }
}
