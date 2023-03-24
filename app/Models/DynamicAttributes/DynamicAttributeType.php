<?php

namespace App\Models\DynamicAttributes;

use App\Models\Status;
use App\Models\BaseModel;
use App\Enums\ValueTypeEnum;
use Illuminate\Support\Carbon;
use Illuminate\Database\Query\Builder;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class DynamicAttributeType
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
 * @property string $code
 * @property string $model_type
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static DynamicAttributeType create(array $array)
 * @method static Builder string()
 * @method static Builder int()
 * @method static Builder datetime()
 * @method static Builder boolean()
 * @method static DynamicAttributeType first()
 */
class DynamicAttributeType extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'name' => ['required'],
            'model_type' => ['required'],
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [
            'code' => ['required','unique:' . (new self())->getTable() . ',code,NULL,id'],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'code' => ['required','unique:' . (new self())->getTable() . ',code,'.$model->id.',id'],
        ]);
    }

    public static function messagesRules() {
        return [
            'name.required' => "Prière de renseigner le name",
            'model_type.required' => "Prière de renseigner le Type de Modèle",
            'code.required' => "Prière de renseigner le code",
            'code.unique' => "Le code doit être unique",
        ];
    }

    #endregion

    #region Scopes
    public function scopeString($query) {
        return $query
            ->where('code', ValueTypeEnum::STRING->value);
    }
    public function scopeInt($query) {
        return $query
            ->where('code', ValueTypeEnum::INT->value);
    }
    public function scopeDatetime($query) {
        return $query
            ->where('code', ValueTypeEnum::DATETIME->value);
    }
    public function scopeBoolean($query) {
        return $query
            ->where('code', ValueTypeEnum::BOOLEAN->value);
    }
    #endregion

    #region Eloquent Relationships

    #endregion

    #region Custom Functions

    /**
     * Crée (et stocke dans la base de données) un nouveau Type d'Attribut Dynamique
     * @param string $name
     * @param string $code
     * @param string $model_type
     * @param Status|null $status
     * @param string|null $description
     * @return DynamicAttributeType
     */
    public static function createNew(string $name, string $code, string $model_type, Status $status = null, string $description = null): DynamicAttributeType
    {
        $attributetype = DynamicAttributeType::create([
            'name' => $name,
            'code' => $code,
            'model_type' => $model_type,
            'description' => $description,
        ]);

        $attributetype->status()->associate( $status ?? Status::default()->first() );
        $attributetype->save();

        return $attributetype;
    }

    /**
     * Modifie (et stocke dans la base de données) ce Type d'Attribut Dynamique
     * @param string $name
     * @param string $code
     * @param string $model_type
     * @param Status|null $status
     * @param string|null $description
     * @return $this
     */
    public function updateOne(string $name, string $code, string $model_type, Status $status = null, string $description = null): DynamicAttributeType
    {
        $this->name = $name;
        $this->code = $code;
        $this->model_type = $model_type;
        $this->description = $description;

        $this->status()->associate( $status ?? Status::default()->first() );
        $this->save();

        return $this;
    }

    #endregion
}
