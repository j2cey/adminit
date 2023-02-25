<?php

namespace App\Models\AnalysisRules;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Contracts\AnalysisRules\IInnerHighlight;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AnalysisHighlightType
 * @package App\Models\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property string|IInnerHighlight $model_type
 * @property string $view_name
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AnalysisHighlightType extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'name' => ['required'],
            'model_type' => ['required'],
            'view_name' => ['required'],
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

    public static function createNew($name,$model_type,$view_name,$description): AnalysisHighlightType {

        $analysishighlighttype = AnalysisHighlightType::create([
            'name' => $name,
            'model_type' => $model_type,
            'view_name' => $view_name,
            'description' => $description,
        ]);

        $analysishighlighttype->save();

        return $analysishighlighttype;
    }

    #endregion
}
