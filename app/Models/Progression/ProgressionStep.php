<?php

namespace App\Models\Progression;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
class ProgressionStep extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [

        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function messagesRules() {
        return [

        ];
    }

    #endregion

    #region Eloquent Relationships
    public function progression() {
        return $this->belongsTo(Progression::class,"progression_id");
    }
    #endregion

    #region Custom Functions
    /**
     * @param Progression $progression
     * @param string $name
     * @param bool $passed
     * @param string|null $description
     * @return ProgressionStep
     */
    public static function createNew(Progression $progression, string $name, bool $passed, string|null $description): ProgressionStep
    {
        $progressionstep = ProgressionStep::create([
            'name' => $name,
            'passed' => $passed,
            'description' => $description,
        ]);

        $progressionstep->progression()->associate($progression)->save();

        return $progressionstep;
    }
    #endregion
}
