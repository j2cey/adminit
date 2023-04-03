<?php

namespace App\Models\FormattedValue;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class RetrieveActionValue
 * @package App\Models\RetrieveAction
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 *
 * @property string $name
 * @property string $code
 * @property string $formattype_class
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static FormatType create(array $array)
 */
class FormatType extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'name' => ['required'],
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [
            'code' => ['required','unique:format_types,code,NULL,id'],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'code' => ['required','unique:format_types,code,'.$model->id.',id'],
        ]);
    }

    public static function messagesRules() {
        return [
            'name.required' => "Prière de renseigner le Nom",
            'code.required' => "Prière de renseigner le Code",
            'code.unique' => "Ce Code est deja utilisé",
        ];
    }

    #endregion

    #region Scopes

    #endregion

    #region Eloquent Relationships

    #endregion

    #region Custom Functions

    /**
     * Crée (et stocke dans la base de données) un nouveau type de format de valeur
     * @param string $name Le Nom du Type
     * @param string $code Le Code du Type
     * @param string $formattype_class
     * @param string|null $description Description du Type
     * @return FormatType
     */
    public static function createNew(string $name, string $code, string $formattype_class, string $description = null): FormatType
    {
        return FormatType::create([
            'name' => $name,
            'code' => $code,
            'formattype_class' => $formattype_class,
            'description' => $description,
        ]);
    }

    /**
     * Modifie (et stocke dans la base de données) ce type de format de valeur
     * @param string $name Le Nom du Type
     * @param string $code Le Code du Type
     * @param string|null $description Description du Type
     * @return $this
     */
    public function updateOne(string $name, string $code, string $formattype_class, string $description = null): FormatType
    {
        $this->name = $name;
        $this->code = $code;
        $this->formattype_class = $formattype_class;
        $this->description = $description;

        $this->save();

        return $this;
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
