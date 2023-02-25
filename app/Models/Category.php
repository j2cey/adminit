<?php

namespace App\Models;

use App\Traits\Code\HasCode;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Category
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property string $title
 * @property string $full_path
 * @property string $code
 * @property string $description
 *
 * @property integer|null $category_parent_id
 * @property integer $posi
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Category extends BaseModel implements Auditable
{
    use HasFactory, HasCode, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'title' => ['required'],
            'code' => ['required'],
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

    public function categoryparent() {
        return $this->belongsTo(Category::class, 'category_parent_id');
    }

    public function subcategories() {
        return $this->hasMany(Category::class, 'category_parent_id');
    }

    #endregion

    #region Custom Functions

    #endregion

    public static function getReflexiveParentIdField()
    {
        return "category_parent_id";
    }

    public static function getTitleField()
    {
        return "title";
    }

    public static function getReflexiveFullPathField()
    {
        return "full_path";
    }

    public function getReflexiveChildrenRelationName()
    {
        return "subcategories";
    }
}
