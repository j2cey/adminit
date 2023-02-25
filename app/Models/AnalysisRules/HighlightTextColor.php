<?php

namespace App\Models\AnalysisRules;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\AnalysisRules\IsInnerHighlight;
use App\Contracts\AnalysisRules\IInnerHighlight;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class HighlightTextColor
 * @package App\Models\AnalysisRules
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $highlight
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class HighlightTextColor extends BaseModel implements IInnerHighlight
{
    use HasFactory, IsInnerHighlight;

    protected $guarded = [];
    protected $table = 'highlight_text_colors';
    protected $with = ['status'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'highlight' => ['required'],
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

    public static function createNew(): HighlightTextColor {

        $innerhighlight = HighlightTextColor::create();

        return $innerhighlight;
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
