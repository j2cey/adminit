<?php

namespace App\Http\Resources\Progression;

use Illuminate\Support\Carbon;
use App\Http\Resources\StatusResource;
use App\Models\Progression\Progression;
use App\Models\Progression\ProgressionStep;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Progression
 * @package App\Models\Progression
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property integer $nb_todo
 * @property integer $nb_done
 * @property integer $nb_passed
 * @property integer $rate
 * @property integer $rate_passed
 * @property boolean $exec_done
 * @property string $current_step
 *
 * @property string|null $description
 * @property integer|null $upper_progression_id
 * @property integer|null $lastprogressionstep_id
 *
 * @property string|null $hasprogression_type
 * @property integer|null $hasprogression_id
 * @property string|null $todos
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Progression|null $upperprogression
 * @property ProgressionStep|null $lastprogressionstep
 * @property Progression[] $subprogressions
 * @property ProgressionStep[] $progressionsteps
 * @method static Progression create(array $array)
 */
class ProgressionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'status' => StatusResource::make($this->status),

            'nb_todo' => $this->nb_todo,
            'nb_done' => $this->nb_done,
            'nb_passed' => $this->nb_passed,
            'rate' => $this->rate,
            'rate_passed' => $this->rate_passed,
            'exec_done' => $this->exec_done,
            'current_step' => $this->current_step,
            'todos' => $this->todos,

            'description' => $this->description,

            'hasprogression_type' => $this->hasprogression_type,
            'hasprogression_id' => $this->hasprogression_id,
            'upper_progression_id' => $this->upper_progression_id,
            'lastprogressionstep_id' => $this->lastprogressionstep_id,

            'lastprogressionstep' => ProgressionStepResource::make($this->lastprogressionstep),
            'progressionsteps' => ProgressionStepResource::collection($this->progressionsteps),

            'created_at' => $this->created_at,

            'show_url' => route('progressions.show', $this->uuid),
            'edit_url' => route('progressions.edit', $this->uuid),
            'destroy_url' => route('progressions.destroy', $this->uuid),
        ];
    }
}
