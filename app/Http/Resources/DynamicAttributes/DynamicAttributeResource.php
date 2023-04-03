<?php

namespace App\Http\Resources\DynamicAttributes;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use App\Models\AnalysisRule\AnalysisRule;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Models\DynamicAttributes\DynamicAttributeType;
use App\Http\Resources\AnalysisRules\AnalysisRuleResource;

/**
 * Class DynamicAttributeResource
 * @package App\Http\Resources\DynamicAttributes
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property integer|null $num_ord
 * @property string|null $description
 *
 * @property string $offset
 * @property integer $max_length
 * @property bool $searchable
 * @property bool $sortable
 *
 * @property string $hasdynamicattribute_type
 * @property integer $hasdynamicattribute_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property DynamicAttributeType $dynamicattributetype
 * @property AnalysisRule $analysisrules
 * @property Status $status
 */
class DynamicAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => StatusResource::make($this->status),

            'name' => $this->name,
            'num_ord' => $this->num_ord,
            'description' => $this->description,

            'offset' => $this->offset,
            'max_length' => $this->max_length,
            'searchable' => $this->searchable,
            'sortable' => $this->sortable,

            'hasdynamicattribute_type' => $this->hasdynamicattribute_type,
            'hasdynamicattribute_id' => $this->hasdynamicattribute_id,

            'dynamicattributetype' => DynamicAttributeTypeResource::make($this->dynamicattributetype),
            'analysisrules' => AnalysisRuleResource::collection($this->analysisrules),

            'model_type' => DynamicAttribute::class,

            'created_at' => $this->created_at,

            'show_url' => route('dynamicattributes.show', $this->uuid),
            'edit_url' => route('dynamicattributes.edit', $this->uuid),
            'destroy_url' => route('dynamicattributes.destroy', $this->uuid),
        ];
    }
}
