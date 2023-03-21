<?php

namespace App\Http\Resources\ReportFile;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Access\AccessAccount;
use App\Models\ReportFile\ReportFile;
use App\Models\Access\AccessProtocole;
use App\Http\Resources\StatusResource;
use App\Models\OsAndServer\ReportServer;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Access\AccessAccountResource;
use App\Http\Resources\Access\AccessProtocoleResource;
use App\Http\Resources\OsAndServer\ReportServerResource;

/**
 * Class ReportFileAccessResource
 * @package App\Http\Resources\ReportFile
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $name
 * @property string|null $code
 * @property string|null $description
 *
 * @property bool $retrieve_by_name
 * @property bool $retrieve_by_wildcard
 *
 * @property integer $report_file_id
 * @property integer $report_server_id
 * @property integer $access_protocole_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 *
 * @property Status $status
 * @property ReportFile $reportfile
 * @property AccessAccount $accessaccount
 * @property ReportServer $reportserver
 * @property AccessProtocole $accessprotocole
 */
class ReportFileAccessResource extends JsonResource
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

            'reportfile' => $this->reportfile,
            'accessaccount' => AccessAccountResource::make($this->accessaccount),
            'reportserver' => ReportServerResource::make($this->reportserver),
            'accessprotocole' => AccessProtocoleResource::make($this->accessprotocole),

            'code' => $this->code,
            'name' => $this->name,
            'retrieve_by_name' => $this->retrieve_by_name,
            'retrieve_by_wildcard' => $this->retrieve_by_wildcard,

            'description' => $this->description,
            'created_at' => $this->created_at,

            'show_url' => route('reportfileaccesses.show', $this->uuid),
            'edit_url' => route('reportfileaccesses.edit', $this->uuid),
            'destroy_url' => route('reportfileaccesses.destroy', $this->uuid),
        ];
    }
}
