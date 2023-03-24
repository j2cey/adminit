<?php

namespace App\Http\Resources\AnalysisRules;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ComparisonTypeResource
 * @package App\Http\Resources\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $label
 * @property string $code
 * @property string $inner_comparison_class
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 */
class ComparisonTypeResource extends JsonResource
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

            'label' => $this->label,
            'code' => $this->code,
            'inner_threshold_class' => $this->inner_comparison_class,
            'description' => $this->description,

            'created_at' => $this->created_at,

            'show_url' => route('comparisontypes.show', $this->uuid),
            'edit_url' => route('comparisontypes.edit', $this->uuid),
            'destroy_url' => route('comparisontypes.destroy', $this->uuid),
        ];
    }
}
