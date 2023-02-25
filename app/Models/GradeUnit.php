<?php

namespace App\Models;

use PHPUnit\Util\Json;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class GradeUnit
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property string $title
 * @property string $unit
 * @property integer|null $unitvalue
 * @property string|null $description
 *
 * @property integer|null $grade_unit_parent_id
 * @property Json $relative_expression
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class GradeUnit extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'title' => ['required'],
            'unit' => ['required'],
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

    public function unitparent() {
        return $this->belongsTo(GradeUnit::class, 'grade_unit_parent_id');
    }

    #endregion

    #region Custom Functions

    public function getOriginUnit() {
        $unitparent = $this->unitparent;
        if ($unitparent) {
            return $unitparent->getOriginUnit();
        } else {
            return $this;
        }
    }

    #endregion
}
