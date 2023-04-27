<?php

namespace App\Http\Resources\ReportFile;

use App\Models\ReportFile\CollectedReportFile;
use App\Models\ReportFile\ReportFile;
use App\Models\RetrieveAction\SelectedRetrieveAction;
use App\Http\Resources\RetrieveAction\SelectedRetrieveActionResource;
use function route;
use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Http\Resources\StatusResource;
use App\Models\ReportFile\ReportFileType;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ReportFileResource
 * @package App\Http\Resources\ReportFile
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
 * @property CollectedReportFile[] $collectedreportfiles
 * @property SelectedRetrieveAction[] $selectedretrieveactions
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
            'collectedreportfiles' => CollectedReportFileResource::collection($this->collectedreportfiles),
            'selectedretrieveactions' => SelectedRetrieveActionResource::collection($this->selectedretrieveactions),

            'report' => $this->report,

            'name' => $this->name,
            'wildcard' => $this->wildcard,

            'remotedir_relative_path' => $this->remotedir_relative_path,
            'remotedir_absolute_path' => $this->remotedir_absolute_path,
            'use_file_extension' => $this->use_file_extension,
            'has_headers' => $this->has_headers,
            'model_type' => ReportFile::class,

            //'selectedretrieveactions' => SelectedRetrieveActionResource::collection($this->selectedretrieveactions),

            'description' => $this->description,
            'created_at' => $this->created_at,

            'show_url' => route('reportfiles.show', $this->uuid),
            'edit_url' => route('reportfiles.edit', $this->uuid),
            'destroy_url' => route('reportfiles.destroy', $this->uuid),
        ];
    }
}
