<?php

namespace App\Http\Resources\AnalysisRules;

use JsonSerializable;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\AnalysisRuleComparison\ComparisonGreaterThan;

/**
 * Class ThresholdMaxResource
 * @package App\Http\Resources\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 */
class ComparisonGreaterThanResource extends JsonResource
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

            'comment' => $this->comment,

            'created_at' => $this->created_at,

            'model_type' => ComparisonGreaterThan::class,

            'show_url' => route('comparisongreaterthans.show', $this->uuid),
            'edit_url' => route('comparisongreaterthans.edit', $this->uuid),
            'destroy_url' => route('comparisongreaterthans.destroy', $this->uuid),
        ];
    }
}
