<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use App\Models\BaseModel;
use App\Jobs\NotifyReportJob;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Jobs\ImportReportFileJob;
use App\Jobs\FormatReportFileJob;
use App\Jobs\CollectReportFileJob;
use App\Enums\TreatmentResultEnum;
use App\Enums\CriticalityLevelEnum;
use App\Models\Access\AccessAccount;
use App\Models\Access\AccessProtocole;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\OsAndServer\ReportServer;
use App\Traits\RowConfig\HasLastRowConfig;
use App\Contracts\RowConfig\IHasLastRowConfig;
use App\Models\RetrieveAction\SelectedRetrieveAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Traits\ReportTreatmentResult\HasReportTreatmentResults;
use App\Traits\SelectedRetrieveAction\HasSelectedRetrieveActions;
use App\Contracts\ReportTreatmentResult\IHasReportTreatmentResults;
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
 * @property Report $report
 * @property ReportFileType $reportfiletype
 * @property string $extension
 * @property string $fileRemotePath
 * @property mixed $selectedretrieveactions
 * @property CollectedReportFile[] $collectedreportfiles
 * @property CollectedReportFile $latestCollectedReportFile
 *
 * @method static ReportFile first()
 */
class ReportFile extends BaseModel implements Auditable, IHasSelectedRetrieveActions, IHasReportTreatmentResults, IHasLastRowConfig
{
    use HasFactory, HasSelectedRetrieveActions, HasReportTreatmentResults, HasLastRowConfig, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    //protected $appends = ['revenue'];

    protected $with = ['report','reportfiletype'];//,'selectedretrieveactions'];

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
        return $this->remotedir_relative_path . "/" . $this->name . ( $this->use_file_extension ? "." . $this->extension : "");
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

    private function setDefaultSelectedRetrieveActions() {
        $this->setDefaultActionsFromSettings();
    }

    public function dissociateSelectedActions(SelectedRetrieveAction $selectedretrieveaction): ?bool
    {
        $selectedretrieveaction->reportfile()->dissociate()->save();

        return true;
    }






    public function exec() {

        // On récupère les traitements en cours
        $report_treatments_to_be_completed = $this->getReportTreatmentsToBeCompleted();

        if ( is_null($report_treatments_to_be_completed) ) $report_treatments_to_be_completed = [];

        $nb_not_completed_executed = 0;

        foreach ($report_treatments_to_be_completed as $report_treatment_to_be_completed) {
            if ( is_null($report_treatment_to_be_completed->currentstep) ) {
                // si il n'y a pas d'etape en cours, on execute le traitement
                $this->execStep($report_treatment_to_be_completed);
            } elseif ( $report_treatment_to_be_completed->currentstep->isSuccess ) {
                // si l'étape en cours est success, on passe a la suivante (ou a la fin)
                $nb_not_completed_executed++;
                $this->execStep($report_treatment_to_be_completed, true);
            } else {
                // si l'étape en cours est failed et critique
                if (
                    $report_treatment_to_be_completed->currentstep->result == TreatmentResultEnum::FAILED &&
                    $report_treatment_to_be_completed->currentstep->criticality_level == CriticalityLevelEnum::HIGH
                ) {
                    // on essaie a nouveau d'executer cette etape
                    $nb_not_completed_executed++;
                    $this->execStep($report_treatment_to_be_completed);
                } else {
                    // sinon, passe a l'etape suivante (ou a la fin)
                    $this->execStep($report_treatment_to_be_completed, true);
                }
            }

        }

        if ($nb_not_completed_executed == 0) {
            // s'il n'y a pas de traitement en attente a executer pour ce rapport,
            // on lance le telechargement d'un nouveau fichier
            $reporttreatmentresult = $this->addReportTreatmentResult("Traitement du fichier " . $this->name . " Rapport " . $this->report->title);
            $this->collectFile($reporttreatmentresult, true);
        }
    }

    private function execStep(ReportTreatmentResult $reporttreatmentresult, $nextStep = false, $dispatch = true) {
        if ($nextStep) {
            $reporttreatmentresult->goToNextStep();
        }
        if ($reporttreatmentresult->currentstep_num === 0) {
            // Récupération Fichier
            $this->collectFile($reporttreatmentresult, $dispatch);
        } elseif ($reporttreatmentresult->currentstep_num === 1) {
            // Importation dans la BD
            $this->importLastCollectedFile($reporttreatmentresult, $dispatch);
        } elseif ($reporttreatmentresult->currentstep_num === 2) {
            // Formattage des donnees importees
            $this->formatLastCollectedFile($reporttreatmentresult, $dispatch);
        } elseif ($reporttreatmentresult->currentstep_num === 3) {
            // Notification du Rapport
            $this->notifyLastCollectedFile($reporttreatmentresult, $dispatch);
        } else {
            // Fin de Traitement
            $reporttreatmentresult->setEnd();
        }
    }


    public function collectFile(ReportTreatmentResult $reporttreatmentresult, $dispatch = false) {
        $reportfileaccess = $this->getActiveReportFileAccess();
        if ($dispatch) {
            CollectReportFileJob::dispatch($reporttreatmentresult, $reportfileaccess);
        } else {
            $reportfileaccess->executeTreatment($reporttreatmentresult);
        }
    }

    public function importLastCollectedFile(ReportTreatmentResult $reporttreatmentresult, $dispatch = false) {
        $latestcollectedreportfile = $this->latestCollectedReportFile;
        if ($dispatch) {
            ImportReportFileJob::dispatch($reporttreatmentresult, $latestcollectedreportfile);
        } else {
            $latestcollectedreportfile->importToDb($reporttreatmentresult);
        }
    }

    public function formatLastCollectedFile(ReportTreatmentResult $reporttreatmentresult, $dispatch = false) {
        $latestcollectedreportfile = $this->latestCollectedReportFile;
        if ($dispatch) {
            FormatReportFileJob::dispatch($reporttreatmentresult, $latestcollectedreportfile);
        } else {
            $latestcollectedreportfile->formatImportedValues($reporttreatmentresult);
        }
    }

    public function notifyLastCollectedFile(ReportTreatmentResult $reporttreatmentresult, $dispatch = false) {
        $latestcollectedreportfile = $this->latestCollectedReportFile;
        if ($dispatch) {
            NotifyReportJob::dispatch($reporttreatmentresult, $latestcollectedreportfile);
        } else {
            $latestcollectedreportfile->notify($reporttreatmentresult);
        }
    }

    /**
     * @param $reportfileId
     * @return ReportFile|null
     */
    public static function getById($reportfileId) {
        return ReportFile::find($reportfileId);
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
