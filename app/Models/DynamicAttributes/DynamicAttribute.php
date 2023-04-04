<?php

namespace App\Models\DynamicAttributes;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnalysisRule\AnalysisRule;
use App\Traits\FormatRule\HasFormatRules;
use App\Models\AnalysisRule\AnalysisRuleType;
use App\Contracts\FormatRule\IHasFormatRules;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\DynamicAttribute\IHasDynamicAttributes;

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
 * @property bool $searchable
 * @property bool $sortable
 *
 * @property string $hasdynamicattribute_type
 * @property integer $hasdynamicattribute_id
 *
 * @property integer $dynamic_attribute_type_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property DynamicAttributeType $dynamicattributetype
 *
 * @method static DynamicAttribute first()
 */
class DynamicAttribute extends BaseModel implements IHasFormatRules
{
    use HasFactory, HasFormatRules, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected array $with = ['dynamicattributetype'];
    protected $casts = [
        'searchable' => 'boolean',
        'sortable' => 'boolean',
    ];

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'dynamicattributetype' => ['required'],
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [
            'name' => ['required','unique:dynamic_attributes,name,NULL,id'],
        ]);
    }

    public static function updateRules($model)
    {
        return array_merge(self::defaultRules(), [
            'name' => ['required','unique:dynamic_attributes,name,'.$model->id.',id'],
        ]);
    }

    public static function messagesRules() {
        return [
            'name.required' => "Prière de renseigner le nom",
            'name.unique' => "Ce nom de projet est déjà utilisé",
            'dynamicattributetype.required' => "Prière de renseigner le Type",
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function dynamicattributetype() {
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
        return $this->hasMany(DynamicValue::class, "dynamic_attribute_id");
    }

    /**
     * The lastest (Dynqmic) value of this attribute
     * @return HasOne
     */
    public function latestValue() {
        return $this->hasOne($this->dynamicattributetype->model_type, "dynamic_attribute_id")
            ->latest();
    }

    public function oldestValue() {
        return $this->hasOne($this->dynamicattributetype->model_type, "dynamic_attribute_id")
            ->oldest();
    }

    #endregion

    #region Custom Functions

    /**
     * @param IHasDynamicAttributes $model
     * @param Model|DynamicAttributeType $dynamicattributetype
     * @param string $name
     * @param Status|null $status
     * @param string|null $description
     * @return DynamicAttribute
     */
    public static function createNew(IHasDynamicAttributes $model, Model|DynamicAttributeType $dynamicattributetype, string $name, Status $status = null, string $description = null, int $offset = null, int $max_length = null, bool $searchable = null, bool $sortable = null): DynamicAttribute {
        return $model->addDynamicAttribute($name, $dynamicattributetype, $status, $description, $offset, $max_length, $searchable, $sortable);
    }

    /**
     * @param Model|DynamicAttributeType $dynamicattributetype
     * @param string $name
     * @param Status|null $status
     * @param string|null $description
     * @param int|null $offset
     * @param int|null $max_length
     * @param bool|null $searchable
     * @param bool|null $sortable
     * @return $this
     */
    public function updateThis(
        Model|DynamicAttributeType $dynamicattributetype,
        string $name,
        Status $status = null,
        string $description = null,
        int $offset = null,
        int $max_length = null,
        bool $searchable = null,
        bool $sortable = null
    ): DynamicAttribute
    {
        $this->name = $name;
        $this->description = $description;
        $this->offset = $offset;
        $this->max_length = $max_length;
        $this->searchable = $searchable;
        $this->sortable = $sortable;

        $this->dynamicattributetype()->associate($dynamicattributetype);
        if ( ! is_null($status) ) {
            $this->status()->associate($status);
        }

        $this->save();

        return $this;
    }

    public function addAnalysisRule(Model|AnalysisRuleType $analysisruletype, string $title, bool $alert_when_allowed, bool $alert_when_broken, string $description = null): AnalysisRule
    {
        return AnalysisRule::createNew($this,$analysisruletype,$title,null,$alert_when_allowed,$alert_when_broken,$description);
    }



    public function addValue($thevalue, DynamicRow $new_dynamicrow) {
        return DynamicValue::createNew($thevalue,$this,$new_dynamicrow);
    }

    #endregion
}
