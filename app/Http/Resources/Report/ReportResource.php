<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DynamicAttributes\DynamicAttributeResource;

/**
 * Class ReportResource
 * @package App\Http\Resources\Report
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $title
 * @property integer|null $report_type_id
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ReportResource extends JsonResource
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

            'reporttype' => ReportTypeResource::make($this->reporttype),
            'attributes' => DynamicAttributeResource::collection($this->dynamicattributes),
            'model_type' => Report::class,

            'created_at' => $this->created_at,

            'show_url' => route('reports.show', $this->uuid),
            'edit_url' => route('reports.edit', $this->uuid),
            'destroy_url' => route('reports.destroy', $this->uuid),
        ];
    }
}
