<?php

namespace App\Http\Resources\ReportFile;

use App\Models\Status;
use Illuminate\Support\Carbon;
use App\Models\ReportFile\ReportFile;
use App\Http\Resources\StatusResource;
use Illuminate\Support\Facades\Request;
use App\Models\ReportFile\ReportFileType;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CollectedReportFileResource
 * @package App\Http\Resources\ReportFile
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $initial_file_name
 * @property string $local_file_name
 * @property string $file_size
 * @property string|null $description
 *
 * @property ReportFile $reportfile
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property int $nb_rows
 * @property int $nb_rows_import_success
 * @property int $nb_rows_import_failed
 * @property int $nb_rows_import_processing
 * @property int $nb_rows_import_processed
 * @property int $row_last_processed
 * @property int $nb_import_try
 *
 * @property int $imported
 * @property int $import_processing
 *
 * @property string $lines_values
 *
 * @property Status $status
 */
class CollectedReportFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => StatusResource::make($this->status),

            'initial_file_name' => $this->initial_file_name,
            'local_file_name' => $this->local_file_name,
            'file_size' => $this->file_size,
            'description' => $this->description,

            'reportfile' => $this->reportfile,

            'created_at' => $this->created_at,

            'nb_rows' => $this->nb_rows,
            'nb_rows_import_success' => $this->nb_rows_import_success,
            'nb_rows_import_failed' => $this->nb_rows_import_failed,
            'nb_rows_import_processing' => $this->nb_rows_import_processing,
            'nb_rows_import_processed' => $this->nb_rows_import_processed,
            'row_last_processed' => $this->row_last_processed,
            'nb_import_try' => $this->nb_import_try,

            'imported' => $this->imported,
            'import_processing' => $this->import_processing,
            'lines_values' => $this->lines_values,//json_decode( $this->lines_values, true ),

            'show_url' => route('collectedreportfiles.show', $this->uuid),
            'edit_url' => route('collectedreportfiles.edit', $this->uuid),
            'destroy_url' => route('collectedreportfiles.destroy', $this->uuid),
        ];
    }

    private function getLineValues(){
        $first_arr = json_decode( $this->lines_values );
        $final_arr = [];
        foreach ($first_arr as $json_arr) {
            $final_arr[] = json_decode($json_arr);
        }
        return $final_arr;
    }
}
