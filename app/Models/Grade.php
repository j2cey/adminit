<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Grade
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property integer $value
 * @property integer|null $execution_id
 * @property integer|null $grade_unit_id
 * @property integer $grade_posi
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Grade extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $with = ['status','unit'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'value' => ['required'],
            'grade_unit_id' => ['required'],
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

    public function unit() {
        return $this->belongsTo(GradeUnit::class, 'grade_unit_id');
    }

    public function execution() {
        return $this->belongsTo(Execution::class, 'execution_id');
    }

    #endregion

    #region Custom Functions

    #endregion
}
