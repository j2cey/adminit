<?php

namespace App\Http\Resources\AnalysisRules;

use JsonSerializable;
use Illuminate\Http\Request;
use App\Enums\RuleResultEnum;
use Illuminate\Support\Carbon;
use App\Models\FormatRule\FormatRule;
use App\Http\Resources\StatusResource;
use App\Models\AnalysisRule\AnalysisRule;
use Illuminate\Contracts\Support\Arrayable;
use App\Models\AnalysisRule\AnalysisRuleType;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Contracts\AnalysisRules\IInnerAnalysisRule;
use App\Http\Resources\FormatRule\FormatRuleResource;

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
 * @property string $inneranalysisrule_type
 * @property integer $inneranalysisrule_id
 *
 * @property RuleResultEnum $rule_result_for_notification
 *
 * @property integer|null $analysis_rule_type_id
 * @property integer|null $dynamic_attribute_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property IInnerAnalysisRule $inneranalysisrule
 * @property AnalysisRuleType $analysisruletype
 * @property FormatRule[] $formatrules
 */
class AnalysisRuleResource extends JsonResource
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

            'title' => $this->title,
            'description' => $this->description,

            'rule_result_for_notification' => $this->rule_result_for_notification->toArray(),

            'inneranalysisrule_type' => $this->inneranalysisrule_type,
            'inneranalysisrule_id' => $this->inneranalysisrule_id,
            'analysisruletype' => AnalysisRuleTypeResource::make($this->analysisruletype),
            'inneranalysisrule' => $this->inneranalysisrule,

            'dynamic_attribute_id' => $this->dynamic_attribute_id,
            'model_type' => AnalysisRule::class,

            'formatrules' => FormatRuleResource::collection($this->formatrules),

            'created_at' => $this->created_at,

            'show_url' => route('analysisruletypes.show', $this->uuid),
            'edit_url' => route('analysisruletypes.edit', $this->uuid),
            'destroy_url' => route('analysisruletypes.destroy', $this->uuid),
        ];
    }
}
