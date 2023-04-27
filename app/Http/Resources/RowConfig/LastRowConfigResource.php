<?php

namespace App\Http\Resources\RowConfig;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use App\Models\RowConfig\LastRowConfig;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Http\Resources\DynamicAttributes\DynamicAttributeResource;

/**
 * Class LastRowConfigResource
 * @package App\Http\Resources\RowConfig
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property boolean $ref_by_row_num
 * @property int|null $row_num
 * @property boolean $ref_by_attribute_value
 * @property int|null $dynamic_attribute_id
 * @property string|null $attribute_value
 *
 * @property string|null $description
 * @property string|null $haslastrowconfig_type
 * @property int|null $haslastrowconfig_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property DynamicAttribute $dynamicattribute
 * @property Status $status
 */
class LastRowConfigResource extends JsonResource
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

            'ref_by_row_num' => $this->ref_by_row_num,
            'ref_by_attribute_value' => $this->ref_by_attribute_value,
            'dynamic_attribute_id' => $this->dynamic_attribute_id,
            'attribute_value' => $this->attribute_value,
            'row_num' => $this->row_num,
            'description' => $this->description,

            'haslastrowconfig_type' => $this->haslastrowconfig_type,
            'haslastrowconfig_id' => $this->haslastrowconfig_id,

            'dynamicattribute' => DynamicAttributeResource::make($this->dynamicattribute),

            'model_type' => LastRowConfig::class,

            'created_at' => $this->created_at,

            'show_url' => route('lastrowconfigs.show', $this->uuid),
            'edit_url' => route('lastrowconfigs.edit', $this->uuid),
            'destroy_url' => route('lastrowconfigs.destroy', $this->uuid),
        ];
    }
}
