<?php

namespace App\Models\DynamicAttributes;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\AnalysisRules\AnalysisRule;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class DynamicAttribute
 * @package App\Models\DynamicAttributes
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property integer $num_ord
 * @property string|null $description
 *
 * @property string $offset
 * @property integer $max_length
 *
 * @property string $hasdynamicattribute_type
 * @property integer $hasdynamicattribute_id
 *
 * @property integer $dynamic_attribute_type_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class DynamicAttribute extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['attributetype'];

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'name' => ['required'],
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

    #region Eloquent Relationships

    public function attributetype() {
        return $this->belongsTo(DynamicAttributeType::class,"dynamic_attribute_type_id");
    }

    public function analysisrules()
    {
        return $this->hasMany(AnalysisRule::class, 'dynamic_attribute_id');
    }

    /**
     * The Model which has this Attribute
     *
     * @return MorphTo
     */
    public function hasdynamicattribute()
    {
        return $this->morphTo();
    }

    /**
     * The (Dynqmic) values of this attribute
     * @return HasMany
     */
    public function values() {
        return $this->hasMany($this->attributetype->model_type, "dynamic_attribute_id");
    }

    /**
     * The lastest (Dynqmic) value of this attribute
     * @return HasOne
     */
    public function latestValue() {
        return $this->hasOne($this->attributetype->model_type, "dynamic_attribute_id")
            ->latest();
    }

    public function oldestValue() {
        return $this->hasOne($this->attributetype->model_type, "dynamic_attribute_id")
            ->oldest();
    }

    #endregion

    #region Custom Functions

    public function addValue($thevalue, $new_row = false) {
        if ($new_row) {
            // get new row
            $values_row = DynamicRow::createNew($this->hasdynamicattribute);
        } else {
            // get last row
            $values_row = $this->hasdynamicattribute->latestDynamicrow;
        }

        return $this->values()->create()        // create new value object
            ->setValue($thevalue, $values_row); // set the inner (formatted) value to the just created value object
    }

    #endregion
}
