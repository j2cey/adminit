<?php

namespace App\Http\Resources\AnalysisRules;

use JsonSerializable;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\AnalysisRuleComparison\ComparisonType;

/**
 * Class AnalysisRuleComparisonResource
 * @package App\Http\Resources\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property boolean $with_equality
 * @property string $comparison_type_id
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property ComparisonType $comparisontype
 */
class AnalysisRuleComparisonResource extends JsonResource
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
            'comparisontype' => ComparisonTypeResource::make($this->comparisontype),

            'with_equality' => $this->with_equality,
            'comparison_type_id' => $this->comparison_type_id,
            'comment' => $this->comment,

            'created_at' => $this->created_at,

            'show_url' => route('analysisrulecomparisons.show', $this->uuid),
            'edit_url' => route('analysisrulecomparisons.edit', $this->uuid),
            'destroy_url' => route('analysisrulecomparisons.destroy', $this->uuid),
        ];
    }
}
