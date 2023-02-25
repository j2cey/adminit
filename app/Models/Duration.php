<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Duration
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property Carbon $start_at
 * @property Carbon|null $end_at
 *
 * @property integer|null $execution_id
 * @property integer $duration_posi
 * @property string $description
 *
 * @property integer|null $elapsetime_ticks
 * @property integer|null $elapsetime_years
 * @property integer|null $elapsetime_months
 * @property integer|null $elapsetime_days
 * @property integer|null $elapsetime_hours
 * @property integer|null $elapsetime_minutes
 * @property integer|null $elapsetime_seconds
 * @property integer|null $elapsetime_milliseconds
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Duration extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'start_at' => ['required'],
            'end_at' => ['required'],
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

    public function execution() {
        return $this->belongsTo(Execution::class, 'execution_id');
    }

    #endregion

    #region Custom Functions

    public function setEnd() {
        $this->end_at = Carbon::now();
        $this->save();
    }

    #endregion
}
