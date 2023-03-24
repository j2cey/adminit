<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Models\Access\AccessAccount;
use App\Models\Access\AccessProtocole;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\OsAndServer\ReportServer;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\RetrieveAction\SelectedRetrieveAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\SelectedRetrieveAction\HasSelectedRetrieveActions;
use App\Contracts\SelectedRetrieveAction\IHasSelectedRetrieveActions;

/**
 * Class ReportFile
 * @package App\Models\ReportFile
 *
 * @property integer $id
 *CollectedReportFile
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $name
 * @property string|null $wildcard
 *
 * @property string|null $remotedir_relative_path
 * @property string|null $remotedir_absolute_path
 * @property bool $use_file_extension
 *
 * @property string|null $description
 *
 * @property integer|null $report_file_type_id
 * @property integer|null $report_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property ReportFileType $reportfiletype
 * @property string $extension
 * @property string $fileRemotePath
 * @property mixed $selectedretrieveactions
 */
class ReportFile extends BaseModel implements IHasSelectedRetrieveActions
{
    use HasFactory, HasSelectedRetrieveActions, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $with = ['reportfiletype','selectedretrieveactions'];

    public static function defaultRules() {
        return [
            'name' => ['required'],
            'wildcard' => [
                'without_spaces'
            ],
            'reportfiletype' => ['required'],
            'report' => ['required'],
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
            'name.required' => "Prière de renseigner le nom",
            'wildcard.required' => "Prière de renseigner le caractère générique",
            'wildcard.without_spaces' => "Le Wildcard ne doit pas comporter des espaces",
            'report.required' => "Prière de renseigner le rapport lié à ce fichier",
            'reportfiletype.required' => "Prière de renseigner un type de fichier",
        ];

    }

    #endregion

    #region Eloquent Relationships

    public function report() {
        return $this->belongsTo(Report::class, 'report_id');
    }

    public function reportfiletype() {
        return $this->belongsTo(ReportFileType::class, 'report_file_type_id');
    }

    public function reportfileaccesses() {
        return $this->hasMany(ReportFileAccess::class,'report_file_id');
    }

    public function selectedretrieveactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SelectedRetrieveAction::class,'report_file_id');
    }

    #endregion

    #region Accessors & Mutators

    /**
     * Retourne le type de récupération
     *
     * @return string
     */
    public function getExtensionAttribute() {
        return $this->reportfiletype->extension;
    }

    public function getFileRemotePathAttribute() {
        //variable contenant le chemin , le nom , l'extension du rapport de fichier
        return $file_path_from = $this->remotedir_relative_path . "/" . $this->name . ( $this->use_file_extension ? "." . $this->extension : "");
    }


    /**
     * Retourne le type de récupération
     *
     * @return string
     */
    public function getRetrieveByWildcardLabelAttribute() {
        return config('Settings.reportfile.retrieve_by_wildcard_label');
    }

    /**
     * Retourne le type de récupération
     *
     * @return string
     */
    public function getRetrieveByNameLabelAttribute() {
        return config('Settings.reportfile.retrieve_by_name_label');
    }

    #endregion


    #region Custom Functions

    /**
     * Crée (et stocker dans la base de données) un nouveau Fichier de Rapport
     * @param Report $report Le Rapport auquel le fichier appartient
     * @param ReportFileType $reportfiletype Le Type de fichier
     * @param Status $status Le statut du fichier
     * @param string $name Le Nom du fichier
     * @param string|null $wildcard Le Wildcard
     * @param string|null $description Description du Fichier
     * @param string|null $remotedir_relative_path Chemin relatif du fichier sur le serveur distant
     * @param string|null $remotedir_absolute_path Chemin absolu du fichier sur le serveur distant
     * @param bool $use_file_extension Détermine si l extension du fichier doit être utilisé
     * @return ReportFile
     */
    public static function createNew(Report $report, ReportFileType $reportfiletype, Status $status, string $name, string $wildcard = null, string $description = null, string $remotedir_relative_path = null, string $remotedir_absolute_path = null, bool $use_file_extension = true): ReportFile
    {
        $reportfile = ReportFile::create([
            'name' => $name,
            'wildcard' => $wildcard,
            'remotedir_relative_path' => $remotedir_relative_path ?? "/",
            'remotedir_absolute_path' => $remotedir_absolute_path ?? "/",
            'use_file_extension' => $use_file_extension,
            'description' => $description,
        ]);

        // associate reportfiletype
        $reportfile->reportfiletype()->associate($reportfiletype);

        // associate report
        $reportfile->report()->associate($report);

        // associate status
        $reportfile->status()->associate($status);

        // save le new object
        $reportfile->save();

        // set default actions
        $reportfile->setDefaultSelectedRetrieveActions();

        return $reportfile;
    }

    /**
     * Crée (et stocker dans la base de données) un nouveau Fichier de Rapport
     * @param Report $report Le Rapport auquel le fichier appartient
     * @param ReportFileType $reportfiletype Le Type de fichier
     * @param Status $status Le statut du fichier
     * @param string $name Le Nom du fichier
     * @param string|null $wildcard Le Wildcard
     * @param string|null $description Description du Fichier
     * @param string|null $remotedir_relative_path Chemin relatif du fichier sur le serveur distant
     * @param string|null $remotedir_absolute_path Chemin absolu du fichier sur le serveur distant
     * @param bool $use_file_extension Détermine si l extension du fichier doit être utilisé
     * @return $this
     */
    public function updateOne(Report $report, ReportFileType $reportfiletype, Status $status, string $name, string $wildcard = null, string $description = null, string $remotedir_relative_path = null, string $remotedir_absolute_path = null, bool $use_file_extension = true): ReportFile
    {
        $this->name = $name;
        $this->wildcard = $wildcard;
        $this->remotedir_relative_path = $remotedir_relative_path ?? "/";
        $this->remotedir_absolute_path = $remotedir_absolute_path ?? "/";
        $this->use_file_extension = $use_file_extension;
        $this->description = $description;

        // associate reportfiletype
        $this->reportfiletype()->associate($reportfiletype);

        // associate report
        $this->report()->associate($report);

        // associate status
        $this->status()->associate($status);

        // save le new object
        $this->save();

        return $this;
    }

    public function addReportFileAccess(AccessAccount $accessaccount, ReportServer $reportserver, AccessProtocole $accessprotocole): ReportFileAccess
    {
        return ReportFileAccess::createNew(
            $this,
            $accessaccount,
            $reportserver,
            $accessprotocole
        );
    }

    private function setDefaultSelectedRetrieveActions() {
        $this->setDefaultActionsFromSettings();
    }

    public function dissociateSelectedActions(SelectedRetrieveAction $selectedretrieveaction): ?bool
    {
        $selectedretrieveaction->reportfile()->dissociate()->save();

        return true;
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
