<?php

namespace App\Http\Resources\ReportTreatments;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

/**
 * Class ReportTreatmentResultResource
 * @package App\Http\Resources\ReportTreatments
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property string $state
 * @property string $result
 *
 * @property string $description
 *
 * @property int $currentstep_num
 * @property int $currentstep_id
 * @property int $report_id
 *
 * @property string|null $hasreporttreatmentresults_type
 * @property int|null $hasreporttreatmentresults_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Status $status
 * @property Report $report
 * @property ReportTreatmentStepResult[] $reporttreatmentsteps
 * @property ReportTreatmentStepResult $currentstep
 */
class ReportTreatmentResultResource extends JsonResource
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
            'report' => $this->report,

            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'state' => $this->state,
            'result' => $this->result,

            'reporttreatmentsteps' => ReportTreatmentStepResultResource::collection($this->reporttreatmentsteps),

            'currentstep_num' => $this->currentstep_num,
            'currentstep' => $this->currentstep,
            'hasreporttreatmentresults_type' => $this->hasreporttreatmentresults_type,
            'hasreporttreatmentresults_id' => $this->hasreporttreatmentresults_id,

            'description' => $this->description,
            'created_at' => $this->created_at,


            'show_url' => route('reporttreatmentresults.show', $this->uuid),
            'edit_url' => route('reporttreatmentresults.edit', $this->uuid),
            'destroy_url' => route('reporttreatmentresults.destroy', $this->uuid),
        ];
    }
}
