<?php

namespace App\Models\AnalysisRules;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\AnalysisRules\IsInnerHighlight;
use App\Contracts\AnalysisRules\IInnerHighlight;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class HighlightTextWeight
 * @package App\Models\AnalysisRules
 *
 * @property integer $id
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
class HighlightTextWeight extends BaseModel implements IInnerHighlight
{
    use HasFactory, IsInnerHighlight;

    protected $guarded = [];
    protected $table = 'highlight_text_weights';
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

    public static function createNew(): HighlightTextWeight {

        $innerhighlight = HighlightTextWeight::create();

        return $innerhighlight;
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
