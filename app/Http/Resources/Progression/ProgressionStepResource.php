<?php

namespace App\Http\Resources\Progression;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\FileHeader\FileHeader;
use App\Http\Resources\StatusResource;
use App\Models\Progression\ProgressionStep;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FormatRule\FormatRuleResource;

/**
 * Class ProgressionStepResource
 * @package App\Http\Resources\Progression
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property string $name
 * @property bool $passed
 *
 * @property string|null $description
 * @property int|null $progression_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static ProgressionStep create(array $array)
 */
class ProgressionStepResource extends JsonResource
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
            'passed' => $this->passed,
            'description' => $this->description,

            'progression_id' => $this->progression_id,

            'created_at' => $this->created_at,

            'show_url' => route('progressionsteps.show', $this->uuid),
            'edit_url' => route('progressionsteps.edit', $this->uuid),
            'destroy_url' => route('progressionsteps.destroy', $this->uuid),
        ];
    }
}
