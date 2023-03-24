<?php

namespace App\Http\Resources\ReportFile;

use function route;
use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Http\Resources\StatusResource;
use App\Models\ReportFile\ReportFileType;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class StatusResource
 * @package App\Http\Resources
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property string $name
 * @property string|null $wildcard
 *
 * @property string|null $remotedir_relative_path
 * @property string|null $remotedir_absolute_path
 * @property bool $use_file_extension
 * @property bool $has_headers
 *
 * @property string|null $description
 *
 * @property integer|null $report_file_type_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property ReportFileType $reportfiletype
 *
 * @property string $retrieve_by_wildcard_label
 * @property string $retrieve_by_name_label
 *
 * @property Report $report
 * @property mixed $reportfileaccesses
 */
class ReportFileResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => StatusResource::make($this->status),

            'reportfiletype' => ReportFileTypeResource::make($this->reportfiletype),
            'reportfileaccesses' => ReportFileAccessResource::collection($this->reportfileaccesses),

            'report' => $this->report,

            'name' => $this->name,
            'wildcard' => $this->wildcard,

            'remotedir_relative_path' => $this->remotedir_relative_path,
            'remotedir_absolute_path' => $this->remotedir_absolute_path,
            'use_file_extension' => $this->use_file_extension,
            'has_headers' => $this->has_headers,

            'retrieve_by_wildcard_label' => $this->retrieve_by_wildcard_label,
            'retrieve_by_name_label' => $this->retrieve_by_name_label,

            'description' => $this->description,
            'created_at' => $this->created_at,

            'show_url' => route('reportfiles.show', $this->uuid),
            'edit_url' => route('reportfiles.edit', $this->uuid),
            'destroy_url' => route('reportfiles.destroy', $this->uuid),
        ];
    }
}
