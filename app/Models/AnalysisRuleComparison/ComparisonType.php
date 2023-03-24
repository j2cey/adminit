<?php

namespace App\Models\AnalysisRuleComparison;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Contracts\AnalysisRules\IInnerComparison;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ComparisonType
 * @package App\Models\AnalysisRuleComparison
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $label
 * @property string $code
 * @property string|IInnerComparison $inner_comparison_class
 *
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static ComparisonType create(array $array)
 *
 * @method static lessThan()
 * @method static greterThan()
 * @method static equal()
 * @method static notEqual()
 */
class ComparisonType extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules
    public static function defaultRules()
    {
        return [
            'label' => ['required'],
            'code' => ['required'],
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function updateRules($model)
    {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function messagesRules()
    {
        return [

        ];
    }
    #endregion

    #region Scopes
    public function scopeLessThan($query) {

        return $query
            ->where('code', "lessthan");
    }
    public function scopeGreterThan($query) {
        return $query
            ->where('code', "greterthan");
    }
    public function scopeEqual($query) {
        return $query
            ->where('code', "equal");
    }
    public function scopeNotEqual($query) {
        return $query
            ->where('code', "notequal");
    }
    #endregion

    #region Eloquent Relationships

    #endregion

    #region Custom Functions

    public static function createNew($label, $inner_comparison_class, $code, $description = null): ComparisonType {

        return ComparisonType::create([
            'label' => $label,
            'inner_comparison_class' => $inner_comparison_class,
            'code' => $code,
            'description' => $description,
        ]);
    }

    public function updateThis($label, $inner_comparison_class, $code, $description): ComparisonType {

        $this->label = $label;
        $this->inner_comparison_class = $inner_comparison_class;
        $this->code = $code;
        $this->description = $description;

        $this->save();

        return $this;
    }

    #endregion
}
