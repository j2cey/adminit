<?php

namespace App\Models\FormatRule;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Contracts\FormatRule\IInnerFormatRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FormatRuleType
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
 * @property string|IInnerFormatRule $model_type
 * @property string $view_name
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Builder textColor()
 * @method static Builder textSize()
 * @method static Builder textWeight()
 */
class FormatRuleType extends BaseModel implements Auditable
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
    public function scopeTextColor($query) {

        return $query
            ->where('code', "text_color");
    }

    public function scopeTextSize($query) {
        return $query
            ->where('code', "text_size");
    }

    public function scopeTextWeight($query) {
        return $query
            ->where('code', "text_weight");
    }
    #endregion

    #region Eloquent Relationships

    #endregion

    #region Custom Functions

    public static function createNew($name,$code,$model_type,$view_name,$description): FormatRuleType {

        $formatruletype = FormatRuleType::create([
            'name' => $name,
            'code' => $code,
            'model_type' => $model_type,
            'view_name' => $view_name,
            'description' => $description,
        ]);

        $formatruletype->save();

        return $formatruletype;
    }

    /**
     * @return FormatRuleType|Model|Builder|object
     */
    public static function getTextColor() {
        return FormatRuleType::textColor()->first();
    }

    /**
     * @return FormatRuleType|Model|Builder|object
     */
    public static function getTextSize() {
        return FormatRuleType::textSize()->first();
    }

    /**
     * @return FormatRuleType|Model|Builder|object
     */
    public static function getTextWeight() {
        return FormatRuleType::textWeight()->first();
    }

    #endregion
}
