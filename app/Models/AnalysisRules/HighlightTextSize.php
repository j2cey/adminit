<?php

namespace App\Models\AnalysisRules;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\AnalysisRules\IsInnerHighlight;
use App\Contracts\AnalysisRules\IInnerHighlight;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class HighlightTextSize
 * @package App\Models\AnalysisRules
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer $highlight
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class HighlightTextSize extends BaseModel implements IInnerHighlight
{
    use HasFactory, IsInnerHighlight;

    protected $guarded = [];
    protected $table = 'highlight_text_sizes';
    protected $with = ['status'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'highlight' => ['required','numeric'],
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

    public static function createNew(): HighlightTextSize {

        $innerhighlight = HighlightTextSize::create();

        return $innerhighlight;
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

    #endregion
}
