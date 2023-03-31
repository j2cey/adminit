<?php

namespace App\Models\FormatRule;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\FormatRule\InnerFormatRule;
use App\Contracts\FormatRule\IInnerFormatRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FormatTextWeight
 * @package App\Models\FormatRule
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $format_value
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class FormatTextWeight extends BaseModel implements IInnerFormatRule
{
    use HasFactory, InnerFormatRule;

    protected $guarded = [];
    protected $table = 'format_text_weights';
    protected $with = ['status'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'format_value' => ['required'],
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

    #endregion

    #region Custom Functions

    public static function createNew(): FormatTextWeight {

        return FormatTextWeight::create();
    }

    public static function getList() : array {
        return [
            ['id' => 0, 'label' => "Normal"],
            ['id' => 1, 'label' => "Light"],
            ['id' => 2, 'label' => "Bold"],
            ['id' => 3, 'label' => "Italic"],
        ];
    }

    #endregion
}
