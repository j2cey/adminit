<?php

namespace App\Http\Resources\OsAndServer;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\OsAndServer\OsServer;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class ReportServerResource
 * @package App\Http\Resources\ReportServer
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 *
 * @property string $name
 * @property string $ip_address
 * @property string $domain_name
 * @property string|null $description
 *
 * @property OsServer $osserver
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 *
 * @property Status $status
 */
class ReportServerResource extends JsonResource
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

            'name' => $this->name,
            'ip_address' => $this->ip_address,
            'domain_name' => $this->domain_name,
            'description' => $this->description,

            'osserver' => OsServerResource::make($this->osserver),

            'created_at' => $this->created_at,

            'show_url' => route('reportservers.show', $this->uuid),
            'edit_url' => route('reportservers.edit', $this->uuid),
            'destroy_url' => route('reportservers.destroy', $this->uuid),
        ];
    }
}
