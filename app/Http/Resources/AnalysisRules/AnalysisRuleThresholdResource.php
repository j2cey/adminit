<?php

namespace App\Http\Resources\AnalysisRules;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AnalysisRuleThresholdResource
 * @package App\Http\Resources\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $threshold
 * @property string $threshold_type_id
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AnalysisRuleThresholdResource extends JsonResource
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
            'thresholdtype' => ThresholdTypeResource::make($this->thresholdtype),

            'threshold' => $this->threshold,
            'threshold_type_id' => $this->threshold_type_id,
            'comment' => $this->comment,

            'created_at' => $this->created_at,

            'show_url' => route('analysisrulethresholds.show', $this->uuid),
            'edit_url' => route('analysisrulethresholds.edit', $this->uuid),
            'destroy_url' => route('analysisrulethresholds.destroy', $this->uuid),
        ];
    }
}
