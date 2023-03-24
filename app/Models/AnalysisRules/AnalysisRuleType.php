<?php

namespace App\Models\AnalysisRules;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\Query\Builder;
use OwenIt\Auditing\Contracts\Auditable;
use App\Contracts\AnalysisRules\IInnerRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AnalysisRuleType
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
 * @property string $code
 * @property string|IInnerRule $model_type
 * @property string $view_name
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Builder threshold()
 * @method static Builder comparison()
 * @method static AnalysisRuleType first()
 */
class AnalysisRuleType extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'name' => ['required'],
            'code' => ['required'],
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

    #region Scopes
    public function scopeThreshold($query) {

        return $query
            ->where('code', "threshold");
    }
    public function scopeComparison($query) {
        return $query
            ->where('code', "comparison");
    }
    #endregion

    #region Eloquent Relationships

    #endregion

    #region Custom Functions

    public static function createNew($name,$code,$model_type,$view_name,$description): AnalysisRuleType {

        $attributetype = AnalysisRuleType::create([
            'name' => $name,
            'code' => $code,
            'model_type' => $model_type,
            'view_name' => $view_name,
            'description' => $description,
        ]);

        $attributetype->save();

        return $attributetype;
    }

    #endregion
}
