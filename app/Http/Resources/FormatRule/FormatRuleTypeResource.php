<?php

namespace App\Http\Resources\FormatRule;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class FormatRuleTypeResource
 * @package App\Http\Resources\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property string|IInnerFormatRule $model_type
 * @property string $view_name
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 */
class FormatRuleTypeResource extends JsonResource
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

            'name' => $this->name,
            'model_type' => $this->model_type,
            'view_name' => $this->view_name,
            'description' => $this->description,

            'created_at' => $this->created_at,

            'show_url' => route('formatruletypes.show', $this->uuid),
            'edit_url' => route('formatruletypes.edit', $this->uuid),
            'destroy_url' => route('formatruletypes.destroy', $this->uuid),
        ];
    }
}