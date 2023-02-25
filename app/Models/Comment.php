<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Comment
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property integer|null $user_id
 *
 * @property string $title
 * @property string $comment_text
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Comment extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $with = ['status','user'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'title' => ['required'],
            'comment' => ['required'],
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

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    #endregion

    #region Custom Functions

    #endregion
}
