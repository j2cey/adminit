<?php

namespace App\Http\Resources\AnalysisRules;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use App\Models\AnalysisRuleThreshold\ThresholdMin;
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
class ThresholdMinResource extends JsonResource
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

            'model_type' => ThresholdMin::class,

            'show_url' => route('thresholdmins.show', $this->uuid),
            'edit_url' => route('thresholdmins.edit', $this->uuid),
            'destroy_url' => route('thresholdmins.destroy', $this->uuid),
        ];
    }
}
