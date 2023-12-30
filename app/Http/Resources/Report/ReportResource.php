<?php

namespace App\Http\Resources\Report;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Models\Reports\ReportType;
use App\Models\FileHeader\FileHeader;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ReportFile\ReportFileResource;
use App\Http\Resources\FileHeader\FileHeaderResource;

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
 * @property string|null $attributes_list
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 *
 * @property Status $status
 * @property ReportType $reporttype
 * @property mixed $reportfiles
 * @property FileHeader $fileheader
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
            'attributes_list' => $this->attributes_list,

            'reporttype' => ReportTypeResource::make($this->reporttype),
            'reportfiles' => ReportFileResource::collection($this->reportfiles),
            'fileheader' => FileHeaderResource::make($this->fileheader),

            'model_type' => Report::class,

            'created_at' => $this->created_at,

            'show_url' => route('reports.show', $this->uuid),
            'edit_url' => route('reports.edit', $this->uuid),
            'destroy_url' => route('reports.destroy', $this->uuid),

            'reportfiles_url' => route('reports.reportfiles', $this->uuid),
            'attributes_url' => route('reports.dynamicattributes', $this->uuid),
        ];
    }
}
