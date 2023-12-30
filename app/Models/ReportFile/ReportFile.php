<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use App\Models\BaseModel;
use App\Enums\ValueTypeEnum;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Models\Access\AccessAccount;
use App\Models\Access\AccessProtocole;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\OsAndServer\ReportServer;
use App\Traits\RowConfig\HasLastRowConfig;
use App\Contracts\RowConfig\IHasLastRowConfig;
use App\Traits\ReportTreatment\HasMainTreatments;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Contracts\ReportTreatment\IHasMainTreatments;
use App\Models\RetrieveAction\SelectedRetrieveAction;
use App\Traits\DynamicAttribute\HasDynamicAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\DynamicAttribute\IHasDynamicAttributes;
use App\Traits\SelectedRetrieveAction\HasSelectedRetrieveActions;
use App\Contracts\SelectedRetrieveAction\IHasSelectedRetrieveActions;

/**
 * Class ReportFile
 * @package App\Models\ReportFile
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $name
 * @property string $label
 * @property string|null $wildcard
 *
 * @property string|null $remotedir_relative_path
 * @property string|null $remotedir_absolute_path
 * @property bool $use_file_extension
 * @property bool $has_headers
 *
 * @property string|null $description
 *
 * @property integer|null $report_file_type_id
 * @property integer|null $report_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property string|null $attributes_list
 *
 * @property Report $report
 * @property ReportFileType $reportfiletype
 * @property string $extension
 * @property string $fileRemotePath
 * @property mixed $selectedretrieveactions
 * @property CollectedReportFile[] $collectedreportfiles
 * @property CollectedReportFile $latestCollectedReportFile
 * @property string $localName
 * @property ReportFileReceiver[] $receivers
 *
 * @method static ReportFile first()
 * @method static self create(array $array)
 */
class ReportFile extends BaseModel implements Auditable, IHasDynamicAttributes, IHasSelectedRetrieveActions, IHasMainTreatments, IHasLastRowConfig
{
    use HasFactory, HasDynamicAttributes, HasSelectedRetrieveActions, HasMainTreatments, HasLastRowConfig, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    //protected $appends = ['revenue'];

    protected $with = ['report','reportfiletype'];//,'selectedretrieveactions'];
    public string $runtime_gui;

    public static string $REPORTFILE_TREATMENT_LOG_INFO_PART = "reportfile";

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setRuntimeGUI();
    }

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

    public function collectedreportfiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CollectedReportFile::class,'report_file_id');
    }

    public function latestCollectedReportFile()
    {
        return $this->hasOne(CollectedReportFile::class)->latestOfMany();
    }

    public function receivers() {
        return $this->hasMany(ReportFileReceiver::class,'report_file_id');
    }

    #endregion

    #region SCOPES based Custom Functions

    /**
     * @return ReportFileAccess|null
     */
    public function getActiveReportFileAccess() {
        return $this->reportfileaccesses()->active()->first();
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
        return $this->getFileRemotePath($this->name);
    }

    public function getLocalNameAttribute() {
        // variable du nom en local avec nom , temps , extension
        return $this->runtime_gui . '.' . $this->extension;
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
     * @param Model|ReportFileType $reportfiletype Le Type de fichier
     * @param Model|Status $status Le statut du fichier
     * @param string $name Le Nom du fichier
     * @param string $label Libellé du fichier
     * @param string|null $wildcard Le Wildcard
     * @param string|null $description Description du Fichier
     * @param string|null $remotedir_relative_path Chemin relatif du fichier sur le serveur distant
     * @param string|null $remotedir_absolute_path Chemin absolu du fichier sur le serveur distant
     * @param bool $use_file_extension Détermine si l extension du fichier doit être utilisé
     * @param bool $has_headers Détermine si le fichier a les en-têtes en première ligne
     * @return ReportFile
     */
    public static function createNew(Report $report, Model|ReportFileType $reportfiletype, Model|Status $status, string $name, string $label, string $wildcard = null, string $description = null, string $remotedir_relative_path = null, string $remotedir_absolute_path = null, bool $use_file_extension = true, bool $has_headers = true): ReportFile
    {
        $reportfile = ReportFile::create([
            'name' => $name,
            'label' => $label,
            'wildcard' => $wildcard,
            'remotedir_relative_path' => $remotedir_relative_path ?? "/",
            'remotedir_absolute_path' => $remotedir_absolute_path ?? "/",
            'use_file_extension' => $use_file_extension,
            'has_headers' => $has_headers,
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
        //$reportfile->setDefaultSelectedRetrieveActions();

        return $reportfile;
    }

    /**
     * Crée (et stocker dans la base de données) un nouveau Fichier de Rapport
     * @param Report $report Le Rapport auquel le fichier appartient
     * @param ReportFileType $reportfiletype Le Type de fichier
     * @param Status $status Le statut du fichier
     * @param string $name Le Nom du fichier
     * @param string $label Libellé du fichier
     * @param string|null $wildcard Le Wildcard
     * @param string|null $description Description du Fichier
     * @param string|null $remotedir_relative_path Chemin relatif du fichier sur le serveur distant
     * @param string|null $remotedir_absolute_path Chemin absolu du fichier sur le serveur distant
     * @param bool $use_file_extension Détermine si l extension du fichier doit être utilisé
     * @param bool $has_headers Détermine si le fichier a les en-têtes en première ligne
     * @return $this
     */
    public function updateOne(Report $report, ReportFileType $reportfiletype, Status $status, string $name, string $label, string $wildcard = null, string $description = null, string $remotedir_relative_path = null, string $remotedir_absolute_path = null, bool $use_file_extension = true, bool $has_headers = false): ReportFile
    {
        $this->name = $name;
        $this->label = $label;
        $this->wildcard = $wildcard;
        $this->remotedir_relative_path = $remotedir_relative_path ?? "/";
        $this->remotedir_absolute_path = $remotedir_absolute_path ?? "/";
        $this->use_file_extension = $use_file_extension;
        $this->has_headers = $has_headers;
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

    public function addReportFileAccess(Model|AccessAccount $accessaccount, Model|ReportServer $reportserver, Model|AccessProtocole $accessprotocole): ReportFileAccess
    {
        return ReportFileAccess::createNew(
            $this,
            $accessaccount,
            $reportserver,
            $accessprotocole
        );
    }

    /**
     * Rajoute un attribut à la liste JSON
     * @param DynamicAttribute $dynamicattribute
     * @return void
     */
    public function setAddAttributeToList(DynamicAttribute $dynamicattribute) {
        $attributes_list =  (array) json_decode( $this->attributes_list );
        $new_attribute = [
            'field' => $dynamicattribute->name,
            'key' => $dynamicattribute->name,
            'label' => $dynamicattribute->name,
            'numeric' => ($dynamicattribute->dynamicattributetype->code === ValueTypeEnum::INT->value),
            'searchable' => (bool)$dynamicattribute->searchable,
            'sortable' => (bool)$dynamicattribute->sortable,
            'date' => (bool)($dynamicattribute->dynamicattributetype->code === ValueTypeEnum::DATETIME->value),
        ];
        $attributes_list[] = $new_attribute;

        $this->attributes_list = json_encode( $attributes_list );

        $this->save();
    }

    /**
     * Reset puis refait la liste JSON des attributs
     * @return void
     */
    public function setAttributesList() {
        $this->attributes_list = "[]";
        $this->save();

        $dynamicattributes_ordered = $this->dynamicattributesOrdered;
        foreach ($dynamicattributes_ordered as $dynamicattribute) {
            $this->setAddAttributeToList($dynamicattribute);
        }
    }

    private function setDefaultSelectedRetrieveActions() {
        $this->setDefaultActionsFromSettings();
    }

    public function dissociateSelectedActions(SelectedRetrieveAction $selectedretrieveaction): ?bool
    {
        $selectedretrieveaction->reportfile()->dissociate()->save();

        return true;
    }

    /**
     * @param $reportfileId
     * @return ReportFile|null
     */
    public static function getById($reportfileId) {
        return ReportFile::find($reportfileId);
    }

    /**
     * @return ReportFile[]|null
     */
    public static function getActives() {
        return ReportFile::active()->get();
    }

    private function setRuntimeGUI() {
        $this->runtime_gui = md5($this->name . '_' . time());
    }

    public function getFileRemotePath(string $name) {
        //retourne le chemin , le nom , l'extension du rapport de fichier
        return $this->remotedir_relative_path . "/" . $name . ( $this->use_file_extension ? "." . $this->extension : "");
    }

    #endregion
}
