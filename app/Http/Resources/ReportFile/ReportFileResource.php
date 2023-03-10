<?php

namespace App\Http\Resources\ReportFile;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Http\Resources\StatusResource;
use App\Models\ReportFile\ReportFileType;
use App\Http\Resources\Report\ReportResource;
use Illuminate\Http\Resources\Json\JsonResource;
use function route;

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
 * @property bool|null $retrieve_by_name
 * @property bool|null $retrieve_by_wildcard
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

            'report' => $this->report,

            'name' => $this->name,
            'wildcard' => $this->wildcard,
            'retrieve_by_name' => $this->retrieve_by_name,
            'retrieve_by_wildcard' => $this->retrieve_by_wildcard,

            'retrieve_by_wildcard_label' => $this->retrieve_by_wildcard_label,
            'retrieve_by_name_label' => $this->retrieve_by_name_label,

            'description' => $this->description,
            'created_at' => $this->created_at,

            'show_url' => route('reportfiles.show', $this->uuid),
            'edit_url' => route('reportfiles.edit', $this->uuid),
            'destroy_url' => route('reportfiles.destroy', $this->uuid),
        ];

        //return parent::toArray($request);
    }
}
