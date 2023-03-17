<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use App\Models\BaseModel;
use App\Traits\Code\HasCode;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class RetrieveAction
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
 *
 * @property RetrieveActionType $retrieveactiontype
 */
class RetrieveAction extends BaseModel implements Auditable
{
    use HasFactory, HasCode, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    //protected $with = ['filemimetype'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'name' => ['required'],
            'retrieveactiontype' => ['required'],
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [
            'code' => ['required','unique:retrieve_actions,code,NULL,id'],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'code' => ['required','unique:retrieve_actions,code,'.$model->id.',id'],
        ]);
    }

    public static function messagesRules() {
        return [
            'name.required' => "Prière de renseigner le nom",
            'retrieveactiontype.required' => "Prière de renseigner le Type d'action",
            'code.required' => "Prière de renseigner le code",
            'code.unique' => "Ce code est deja utilise",
        ];
    }

    #endregion

    #region Scopes

    #endregion

    #region Eloquent Relationships

    public function retrieveactiontype() {
        return $this->belongsTo(RetrieveActionType::class, 'retrieve_action_type_id');
    }

    #endregion

    #region Custom Functions

    /**
     * Crée (et stocke dans la base de données) une nouvelle action de récupération (RetrieveAction)
     * @param RetrieveActionType $retrieveactiontype Type d'action
     * @param string $name Nom du Type d'action
     * @param string|null $code Code du Type d'action
     * @param Status|null $status Statut
     * @param string|null $description Description du Type d'action
     * @return RetrieveAction
     */
    public static function createNew(RetrieveActionType $retrieveactiontype, string $name, string $code = null, Status $status = null, string $description = null): RetrieveAction
    {
        $retrieveaction = RetrieveAction::create([
            'name' => $name,
            'code' => is_null($code) ? $name : $code,
            'description' => $description,
        ]);

        $retrieveaction->status()->associate( is_null($status) ? Status::default()->first() : $status );
        $retrieveaction->retrieveactiontype()->associate( $retrieveactiontype );

        $retrieveaction->save();

        return $retrieveaction;
    }

    /**
     * Modifie (et stocke dans la base de données) cette action de récupération (RetrieveAction)
     * @param RetrieveActionType $retrieveactiontype Type d'action
     * @param string $name Nom du Type d'action
     * @param string|null $code Code du Type d'action
     * @param Status|null $status Statut
     * @param string|null $description Description du Type d'action
     * @return $this
     */
    public function updateOne(RetrieveActionType $retrieveactiontype, string $name, string $code = null, Status $status = null, string $description = null): RetrieveAction
    {
        $this->name = $name;
        $this->code = is_null($code) ? $name : $code;
        $this->description = $description;

        $this->status()->associate( is_null($status) ? Status::default()->first() : $status );
        $this->retrieveactiontype()->associate( $retrieveactiontype );

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
