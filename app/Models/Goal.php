<?php

namespace App\Models;

use App\Traits\Code\HasCode;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Goal
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property string $title
 * @property string $code
 * @property string $description
 *
 * @property integer $value
 * @property integer|null $goal_type_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Goal extends BaseModel implements Auditable
{
    use HasFactory, HasCode, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'title' => ['required'],
            'code' => ['required'],
            'value' => ['required','integer'],
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

    public function goaltype() {
        return $this->belongsTo(Goal::class, 'goal_type_id');
    }

    #endregion

    #region Custom Functions

    #endregion
}
