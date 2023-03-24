<?php

namespace App\Models\AnalysisRuleThreshold;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Contracts\AnalysisRules\IInnerThreshold;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ThresholdType
 * @package App\Models\AnalysisRules
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
 * @property string|IInnerThreshold $inner_threshold_class
 *
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static ThresholdType create(array $array)
 * @method static min()
 * @method static max()
 */
class ThresholdType extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules
    public static function defaultRules()
    {
        return [
            'label' => ['required'],
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
    public function scopeMin($query) {

        return $query
            ->where('code', "min");
    }
    public function scopeMax($query) {
        return $query
            ->where('code', "max");
    }
    #endregion

    #region Eloquent Relationships

    #endregion

    #region Custom Functions

    public static function createNew($label, $inner_threshold_class, $code, $description): ThresholdType {

        return ThresholdType::create([
            'label' => $label,
            'inner_threshold_class' => $inner_threshold_class,
            'code' => $code,
            'description' => $description,
        ]);
    }

    public function updateThis($label, $inner_threshold_class, $code, $description): ThresholdType {

        $this->label = $label;
        $this->inner_threshold_class = $inner_threshold_class;
        $this->code = $code;
        $this->description = $description;

        $this->save();

        return $this;
    }

    // Analysis Rule broken

    // Analysis Rule followed

    #endregion
}
