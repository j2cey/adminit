<?php

namespace App\Models\FormatRule;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\FormatRule\InnerFormatRule;
use App\Contracts\FormatRule\IInnerFormatRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FormatTextColor
 * @package App\Models\FormatRule
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $format_value
 *
 * @property int $alpha
 * @property int $blue
 * @property int $green
 * @property int $hue
 * @property int $lightness
 * @property int $red
 * @property int $saturation
 *
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class FormatTextColor extends BaseModel implements IInnerFormatRule
{
    use HasFactory, InnerFormatRule;

    protected $guarded = [];
    //protected $table = 'format_text_colors';
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

    public static function createNew(): FormatTextColor {
        return FormatTextColor::create();
    }

    public function updateOne(string|IInnerFormatRule $innerformatrule = null) {
        if ( ! is_null($innerformatrule) ) {
            $newvalues = is_string($innerformatrule) ? json_decode($innerformatrule, true) : $innerformatrule;

            $this->update([
                'format_value' => $newvalues['format_value'],

                'alpha' => $newvalues['alpha'],
                'blue' => $newvalues['blue'],
                'green' => $newvalues['green'],
                'hue' => $newvalues['hue'],
                'lightness' => $newvalues['lightness'],
                'red' => $newvalues['red'],
                'saturation' => $newvalues['saturation'],

                'comment' => $newvalues['comment'],
            ]);
        }
    }

    public function getRuleValue(): string
    {
        return $this->format_value;
    }

    public static function getList() : array {
        return [
            ['id' => 0, 'label' => "Black"],
            ['id' => 1, 'label' => "Red"],
            ['id' => 2, 'label' => "White"],
            ['id' => 3, 'label' => "Orange"],
        ];
    }

    #endregion
}
