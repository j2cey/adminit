<?php

namespace App\Http\Resources\FormatRule;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\FormatRule\FormatRule;
use App\Http\Resources\StatusResource;
use App\Models\FormatRule\FormatRuleType;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class FormatRuleResource
 * @package App\Http\Resources\FormatRule
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
 * @property string $formatruleowner_type
 * @property int $formatruleowner_id
 *
 * @property string $when_rule_result_is
 *
 * @property string $innerformatrule_type
 * @property int $innerformatrule_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property FormatRuleType $formatruletype
 * @property IInnerFormatRule $innerformatrule
 */
class FormatRuleResource extends JsonResource
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

            'formatruletype' => FormatRuleTypeResource::make($this->formatruletype),

            'innerformatrule' => $this->innerformatrule,

            'formatruleowner_type' => $this->formatruleowner_type,
            'formatruleowner_id' => $this->formatruleowner_id,

            'when_rule_result_is' => $this->when_rule_result_is,

            'innerformatrule_type' => $this->innerformatrule_type,
            'innerformatrule_id' => $this->innerformatrule_id,

            'model_type' => FormatRule::class,

            'created_at' => $this->created_at,

            'show_url' => route('formatrules.show', $this->uuid),
            'edit_url' => route('formatrules.edit', $this->uuid),
            'destroy_url' => route('formatrules.destroy', $this->uuid),
        ];
    }
}