<?php

namespace App\Models\FormatRule;

use Psy\Util\Json;
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
 * @property string|Json $format_value
 * @property string $comment
 *
 * @property bool $format_bold
 * @property bool $format_italic
 * @property bool $format_underline
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
    protected $casts = [
        'format_bold' => 'boolean',
        'format_italic' => 'boolean',
        'format_underline' => 'boolean',
    ];

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

        return FormatTextWeight::create([
            'format_value' => "[]",
        ]);
    }

    public function updateOne(string|IInnerFormatRule $innerformatrule = null) {
        if ( ! is_null($innerformatrule) ) {
            $newvalues = is_string($innerformatrule) ? json_decode($innerformatrule, true) : $innerformatrule;

            $this->update([
                'format_value' => $newvalues['format_value'],
                'comment' => $newvalues['comment'],
                'format_bold' => $newvalues['format_bold'],
                'format_italic' => $newvalues['format_italic'],
                'format_underline' => $newvalues['format_underline'],
            ]);
        }
    }

    public function getFormatValue() {
        $final_format = [];

        if ($this->format_bold) $final_format[] = 'bold';
        if ($this->format_italic) $final_format[] = 'italic';
        if ($this->format_underline) $final_format[] = 'underline';

        return $final_format;
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
