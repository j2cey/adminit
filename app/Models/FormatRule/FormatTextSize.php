<?php

namespace App\Models\FormatRule;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\FormatRule\InnerFormatRule;
use App\Contracts\FormatRule\IInnerFormatRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FormatTextSize
 * @package App\Models\FormatRule
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer $format_value
 * @property string $comment
 *
 * @property int $min_value
 * @property int $max_value
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class FormatTextSize extends BaseModel implements IInnerFormatRule
{
    use HasFactory, InnerFormatRule;

    protected $guarded = [];
    //protected $table = 'format_text_sizes';
    protected $with = ['status'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'format_value' => ['required','numeric'],
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

    public static function createNew(): FormatTextSize {

        $innerformatrule = FormatTextSize::create();

        return $innerformatrule;
    }

    public function updateOne(string|IInnerFormatRule $innerformatrule = null) {
        if ( ! is_null($innerformatrule) ) {
            $newvalues = is_string($innerformatrule) ? json_decode($innerformatrule, true) : $innerformatrule;

            $this->update([
                'format_value' => $newvalues['format_value'],
                'comment' => $newvalues['comment'],
                'min_value' => $newvalues['min_value'],
                'max_value' => $newvalues['max_value'],
            ]);
        }
    }

    public function getFormatValue() {
        return $this->format_value;
    }

    public static function getList() : array {
        $min = 7;
        $max = 30;
        $list = [];

        for ($i = 0; $i <= $max; $i++) {
            $list[] = ['id' => $i, 'label' => $min + $i];
        }

        return $list;
    }

    public function getSizedText() {

    }

    #endregion
}
