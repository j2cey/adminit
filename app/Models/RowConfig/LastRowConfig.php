<?php

namespace App\Models\RowConfig;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\DynamicValue\DynamicRow;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\DynamicAttributes\DynamicAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class LastRowConfig
 * @package App\Models\RowConfig
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property boolean $ref_by_row_num
 * @property int|null $row_num
 * @property boolean $ref_by_attribute_value
 * @property int|null $dynamic_attribute_id
 * @property string|null $attribute_value
 *
 * @property string|null $description
 * @property string|null $haslastrowconfig_type
 * @property int|null $haslastrowconfig_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property DynamicAttribute $dynamicattribute
 * @method static LastRowConfig create(array $array)
 */
class LastRowConfig extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
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

    #endregion

    #region Eloquent Relationships

    public function dynamicattribute() {
        return $this->belongsTo(DynamicAttribute::class, 'dynamic_attribute_id');
    }

    public function haslastrowconfig()
    {
        return $this->morphTo();
    }

    #endregion

    #region Custom Functions

    /**
     * @param bool|null $ref_by_row_num
     * @param int|null $row_num
     * @param bool|null $ref_by_attribute_value
     * @param DynamicAttribute|Model|null $dynamicattribute
     * @param string|null $attribute_value
     * @param Status|null $status
     * @param string|null $description
     * @return LastRowConfig
     */
    public static function createNew(bool $ref_by_row_num = null, int $row_num = null,bool $ref_by_attribute_value = null, DynamicAttribute|Model $dynamicattribute = null, string $attribute_value = null, Status $status = null, string $description = null): LastRowConfig
    {
        $lastrowconfig =  LastRowConfig::create([
            'ref_by_row_num' => $ref_by_row_num ?? false,
            'ref_by_attribute_value' => $ref_by_attribute_value ?? false,
            'attribute_value' => $attribute_value,
            'row_num' => $row_num,
            'description' => $description
        ]);

        if ( ! is_null($status) ) $lastrowconfig->status()->associate($status);
        if ( ! is_null($dynamicattribute) ) $lastrowconfig->dynamicattribute()->associate($dynamicattribute);

        return $lastrowconfig;
    }

    /**
     * @param bool|null $ref_by_row_num
     * @param bool|null $row_num
     * @param bool|null $ref_by_attribute_value
     * @param DynamicAttribute|Model|null $dynamicattribute
     * @param string|null $attribute_value
     * @param Status|null $status
     * @param string|null $description
     * @return $this
     */
    public function updateThis(bool $ref_by_row_num = null,bool $row_num = null,bool $ref_by_attribute_value = null, DynamicAttribute|Model $dynamicattribute = null, string $attribute_value = null, Status $status = null, string $description = null): LastRowConfig
    {
        $this->ref_by_row_num = $ref_by_row_num ?? $this->ref_by_row_num;
        $this->ref_by_attribute_value = $ref_by_attribute_value ?? $this->ref_by_attribute_value;
        $this->attribute_value = $attribute_value ?? $this->attribute_value;
        $this->row_num = $row_num ?? $this->row_num;
        $this->description = $description;

        if ( ! is_null($status) ) $this->status()->associate($status);
        if ( ! is_null($dynamicattribute) ) $this->dynamicattribute()->associate($dynamicattribute);

        $this->save();

        return $this;
    }

    public function isLastRow(DynamicRow $dynamicrow) {
        if ( $this->ref_by_row_num ) {
            return $dynamicrow->line_num === $this->row_num;
        } else {
            if ( $this->dynamicattribute ) {
                return $dynamicrow->isValueEqual($this->dynamicattribute, $this->attribute_value);
            } else {
                return false;
            }
        }
    }

    protected static function boot(){
        parent::boot();

        // Pendant la création de ce Model
        static::creating(function ($model) {

        });

        // Pendant la modification de ce Model
        static::updating(function ($model) {

        });
    }

    #endregion
}
