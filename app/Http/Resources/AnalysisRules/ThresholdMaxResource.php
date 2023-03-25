<?php

namespace App\Http\Resources\AnalysisRules;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use App\Models\AnalysisRuleThreshold\ThresholdMax;
use Illuminate\Http\Resources\Json\JsonResource;

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
 * @property int $threshold
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 */
class ThresholdMaxResource extends JsonResource
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

            'threshold' => $this->threshold,
            'comment' => $this->comment,

            'created_at' => $this->created_at,

            'model_type' => ThresholdMax::class,

            'show_url' => route('thresholdmaxes.show', $this->uuid),
            'edit_url' => route('thresholdmins.edit', $this->uuid),
            'destroy_url' => route('thresholdmaxes.destroy', $this->uuid),
        ];
    }
}
