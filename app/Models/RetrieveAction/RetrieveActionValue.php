<?php

namespace App\Models\RetrieveAction;

use App\Models\Status;
use App\Models\BaseModel;
use App\Enums\ValueTypeEnum;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
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
 * @property string $label
 * @property string $type
 * @property string $value_string
 * @property int $value_int
 * @property Carbon $value_datetime
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 *
 * @property SelectedRetrieveAction $selectedretrieveaction
 * @method static RetrieveActionValue first()
 */
class RetrieveActionValue extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $casts = [
        'type' => ValueTypeEnum::class,
    ];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'selectedretrieveaction' => ['required'],
            'type' => ['required'],
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [
            'label' => ['required','unique:retrieve_action_values,label,NULL,id'],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'label' => ['required','unique:retrieve_action_values,label,'.$model->id.',id'],
        ]);
    }

    public static function messagesRules() {
        return [
            'selectedretrieveaction.required' => "Prière de renseigner l Action sélectionnée",
            'label.required' => "Prière de renseigner le Libellé",
            'label.unique' => "Ce Libellé est deja utilisé",
            'type.required' => "Prière de renseigner le Type de donnée",
        ];
    }

    #endregion

    #region Scopes

    #endregion

    #region Eloquent Relationships

    public function selectedretrieveaction() {
        return $this->belongsTo(SelectedRetrieveAction::class, 'selected_retrieve_action_id');
    }

    #endregion

    #region Custom Functions

    /**
     * Crée (et stocke dans la base de données) une nouvelle valeur pour une action sélectionnée
     * @param SelectedRetrieveAction $selectedretrieveaction Type d'action
     * @param string $label Libellé
     * @param string $type Type de donnée
     * @param string|null $value_string Valeur string
     * @param int|null $value_int valeur integer
     * @param Carbon|null $value_datetime Valeur DateTime
     * @param Model|Status|null $status Statut
     * @param string|null $description Description de l'action
     * @return RetrieveActionValue
     */
    public static function createNew(SelectedRetrieveAction $selectedretrieveaction, string $label, string $type, string $value_string = null, int $value_int = null, Carbon $value_datetime = null, Model|Status $status = null, string $description = null): RetrieveActionValue
    {
        $retrieveactionvalue = RetrieveActionValue::create([
            'label' => $label,
            'type' => $type,
            'value_string' => $value_string,
            'value_int' => $value_int,
            'value_datetime' => $value_datetime,
            'description' => $description,
        ]);

        // Assignation du type de selectedretrieveaction
        $retrieveactionvalue->selectedretrieveaction()->associate($selectedretrieveaction);

        $retrieveactionvalue->status()->associate( is_null($status) ? Status::default()->first() : $status );
        $retrieveactionvalue->SelectedRetrieveAction()->associate( $selectedretrieveaction );

        $retrieveactionvalue->save();

        return $retrieveactionvalue;
    }

    /**
     * Modifie (et stocke dans la base de données) cette action de récupération (RetrieveAction)
     * @param Model|SelectedRetrieveAction $selectedretrieveaction Type d'action
     * @param string $label Libellé
     * @param string $type Type de donnée
     * @param string|null $value_string Valeur string
     * @param int|null $value_int valeur integer
     * @param Carbon|null $value_datetime Valeur DateTime
     * @param Model|Status|null $status Statut
     * @param string|null $description Description de l'action
     * @return $this
     */
    public function updateOne(Model|SelectedRetrieveAction $selectedretrieveaction, string $label, string $type, string $value_string = null, int $value_int = null, Carbon $value_datetime = null, Model|Status $status = null, string $description = null)
    {
        $this->label = $label;
        $this->type = $type;
        $this->value_string = $value_string;
        $this->value_int = $value_int;
        $this->value_datetime = $value_datetime;
        $this->description = $description;

        $this->status()->associate( is_null($status) ? Status::default()->first() : $status );
        $this->SelectedRetrieveAction()->associate( $selectedretrieveaction );

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
