<?php

namespace App\Models\RetrieveAction;

use App\Models\Status;
use App\Models\BaseModel;
use App\Traits\Code\HasCode;
use App\Enums\ValueTypeEnum;
use Illuminate\Support\Carbon;
use App\Models\ReportFile\ReportFile;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\ReportFile\ReportFileAccess;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SelectedRetrieveAction
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
 * @property string $code
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 *
 * @property ReportFile $reportfile
 * @property ReportFileAccess $reportfileaccess
 * @property RetrieveAction $retrieveaction
 * @property mixed $retrieveactionvalues
 *
 * @method static SelectedRetrieveAction first()
 */
class SelectedRetrieveAction extends BaseModel implements Auditable
{
    use HasFactory, HasCode, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['retrieveaction','retrieveactionvalues'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'retrieveaction' => ['required'],
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [
            'code' => ['sometimes','unique:selected_retrieve_actions,code,NULL,id'],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'code' => ['sometimes','unique:selected_retrieve_actions,code,'.$model->id.',id'],
        ]);
    }

    public static function messagesRules() {
        return [
            'retrieveaction.required' => "Prière de renseigner l'action",
            'code.unique' => "Ce code est deja utilisé",
        ];
    }

    #endregion

    #region Scopes

    #endregion

    #region Eloquent Relationships

    public function reportfile() {
        return $this->belongsTo(ReportFile::class, 'report_file_id');
    }
    public function reportfileaccess() {
        return $this->belongsTo(ReportFileAccess::class, 'report_file_access_id');
    }
    public function retrieveaction() {
        return $this->belongsTo(RetrieveAction::class, 'retrieve_action_id');
    }
    public function retrieveactionvalues()
    {
        return $this->hasMany(RetrieveActionValue::class, 'selected_retrieve_action_id');
    }

    public function hasselectedretrieveaction()
    {
        return $this->morphTo();
    }
    #endregion

    #region Scopes

    #endregion

    #region Custom Functions

    /**
     * Crée (et stocke dans la base de données) une nouvelle action de récupération (RetrieveAction)
     * @param Model|RetrieveAction $retrieveaction L'action
     * @param string|null $code Code de selection
     * @param Model|Status|null $status Statut
     * @param string|null $description Description de la sélection
     * @return SelectedRetrieveAction
     */
    public static function createNew(Model|RetrieveAction $retrieveaction, string $code = null, Model|Status $status = null, string $description = null): SelectedRetrieveAction
    {
        $selectedretrieveaction = SelectedRetrieveAction::create([
            'code' => $code,
            'description' => $description,
        ]);

        $selectedretrieveaction->status()->associate( is_null($status) ? Status::default()->first() : $status );
        $selectedretrieveaction->retrieveaction()->associate( $retrieveaction );

        $selectedretrieveaction->save();

        return $selectedretrieveaction;
    }

    /**
     * Modifie (et stocke dans la base de données) cette action de récupération (RetrieveAction)
     * @param RetrieveAction $retrieveaction L'action
     * @param string|null $code Code de selection
     * @param Model|Status|null $status Statut
     * @param string|null $description Description de la sélection
     * @return $this
     */
    public function updateOne(RetrieveAction $retrieveaction, string $code = null, Model|Status $status = null, string $description = null): SelectedRetrieveAction
    {
        $this->code = $code;
        $this->description = $description;

        $this->status()->associate( is_null($status) ? Status::default()->first() : $status );
        $this->retrieveaction()->associate( $retrieveaction );

        $this->save();

        return $this;
    }

    public function addActionValue(string $label,string $type,$value): RetrieveActionValue
    {
        return RetrieveActionValue::createNew(
            $this,
            $label,
            $type,
            ($type === ValueTypeEnum::STRING->value ? $value : null),
            ($type === ValueTypeEnum::INT->value ? $value : null),
            ($type === ValueTypeEnum::DATETIME->value ? $value : null),
            Status::active()->first()
        );
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
