<?php

namespace App\Models\RetrieveAction;

use App\Models\Status;
use App\Models\BaseModel;
use App\Traits\Code\HasCode;
use Illuminate\Support\Carbon;
use Illuminate\Database\Query\Builder;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class RetrieveActionType
 * @package App\Models\ReportFile
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
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Builder retrieveMode()
 * @method static Builder toPerformAfterRetrieving()
 * @method static Builder toPerformBeforeRetrieving()
 * @method static RetrieveActionType first()
 */
class RetrieveActionType extends BaseModel implements Auditable
{
    use HasFactory, HasCode, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    //protected $with = ['filemimetype'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'name' => ['required'],
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [
            'code' => ['required','unique:retrieve_action_types,code,NULL,id'],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'code' => ['required','unique:retrieve_action_types,code,'.$model->id.',id'],
        ]);
    }

    public static function messagesRules() {
        return [
            'name.required' => "Prière de renseigner le nom",
            'code.required' => "Prière de renseigner le code",
            'code.unique' => "Ce code est deja utilise",
        ];
    }

    #endregion

    #region Scopes
    public function scopeRetrieveMode($query) {

        return $query
            ->where('code', "retrieve_mode");
    }

    public function scopeToPerformBeforeRetrieving($query) {
        return $query
            ->where('code', "to_perform_before_retrieving");
    }

    public function scopeToPerformAfterRetrieving($query) {
        return $query
            ->where('code', "to_perform_after_retrieving");
    }
    #endregion

    #region Eloquent Relationships

    public function retrieveactions() {
        return $this->hasMany(RetrieveAction::class, 'retrieve_action_type_id');
    }

    #endregion

    #region Custom Functions

    /**
     * Crée (et stocke dans la base de données) un nouveau Type d'action de récupération (RetrieveActionType)
     * @param string $name Nom du Type d'action
     * @param string|null $code Code du Type d'action
     * @param Status|null $status Statut
     * @param string|null $description Description du Type d'action
     * @return RetrieveActionType
     */
    public static function createNew(string $name, string $code = null, Status $status = null, string $description = null): RetrieveActionType
    {
        $retrieveactiontype = RetrieveActionType::create([
            'name' => $name,
            'code' => is_null($code) ? $name : $code,
            'description' => $description,
        ]);

        $retrieveactiontype->status()->associate( is_null($status) ? Status::default()->first() : $status );
        $retrieveactiontype->save();

        return $retrieveactiontype;
    }

    /**
     * Modifie (et stocke dans la base de données) ce Type d'action de récupération (RetrieveActionType)
     * @param string $name Nom du Type d'action
     * @param string|null $code Code du Type d'action
     * @param Status|null $status Statut
     * @param string|null $description Description du Type d'action
     * @return $this
     */
    public function updateOne(string $name, string $code = null, Status $status = null, string $description = null): RetrieveActionType
    {
        $this->name = $name;
        $this->code = is_null($code) ? $name : $code;
        $this->description = $description;

        $this->status()->associate( is_null($status) ? Status::default()->first() : $status );

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
