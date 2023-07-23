<?php

namespace App\Models\Authorization;

use Illuminate\Support\Carbon;
use App\Traits\Base\HasCreator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * Class Permission
 * @package App\Models\Authorization
 *
 * @property integer $id
 *
 * @property string $name
 * @property integer $level
 * @property string $guard_name
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int|null $created_by user creator reference
 * @property int|null $updated_by user updator reference
 * @property Carbon $deleted_at
 */
class Permission extends SpatiePermission
{
    use HasCreator, SoftDeletes;

    #region Validation Tools

    public static function defaultRules() {
        return [
            'level' => ['required'],
        ];
    }
    public static function createRules()  {
        return array_merge(self::defaultRules(), [
            'name' => ['required',
                'unique:permissions,name,NULL,id',
            ],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'name' => ['required',
                'unique:permissions,name,'.$model->id.',id',
            ]
        ]);
    }
    public static function validationMessages() {
        return [];
    }

    #endregion
}
