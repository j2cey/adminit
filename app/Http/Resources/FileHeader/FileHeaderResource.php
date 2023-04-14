<?php

namespace App\Http\Resources\FileHeader;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\FormatRule\FormatRule;
use App\Models\FileHeader\FileHeader;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FormatRule\FormatRuleResource;

/**
 * Class FileHeaderResource
 * @package App\Http\Resources\FileHeader
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $title
 * @property string|null $description
 *
 * @property string $hasfileheader_type
 * @property integer $hasfileheader_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property FormatRule[] $formatrules
 * @property Status $status
 */
class FileHeaderResource extends JsonResource
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

            'hasfileheader_type' => $this->hasfileheader_type,
            'hasfileheader_id' => $this->hasfileheader_id,

            'formatrules' => FormatRuleResource::collection($this->formatrules),

            'model_type' => FileHeader::class,

            'created_at' => $this->created_at,

            'show_url' => route('fileheaders.show', $this->uuid),
            'edit_url' => route('fileheaders.edit', $this->uuid),
            'destroy_url' => route('fileheaders.destroy', $this->uuid),
        ];
    }
}
