<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use App\Enums\QueueEnum;
use App\Models\BaseModel;
use App\Jobs\NotifyReportJob;
use Illuminate\Support\Carbon;
use App\Models\Reports\Report;
use App\Enums\TreatmentStepCode;
use App\Jobs\ImportReportFileJob;
use App\Jobs\FormatReportFileJob;
use App\Jobs\CollectReportFileJob;
use App\Enums\CriticalityLevelEnum;
use App\Models\Access\AccessAccount;
use Illuminate\Support\Facades\Queue;
use App\Models\Access\AccessProtocole;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\OsAndServer\ReportServer;
use App\Traits\RowConfig\HasLastRowConfig;
use App\Jobs\MergeReportFileFormattedRowsJob;
use App\Contracts\RowConfig\IHasLastRowConfig;
use App\Models\RetrieveAction\SelectedRetrieveAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Traits\ReportTreatment\HasReportTreatmentResults;
use App\Traits\SelectedRetrieveAction\HasSelectedRetrieveActions;
use App\Contracts\ReportTreatment\IHasReportTreatmentResults;
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

        if ( $this->reportTreatmentResultsWaiting()->count() === 0 && $this->reportTreatmentResultsRunning()->count() === 0 && $this->reportTreatmentResultsQueued()->count() === 0 ) {
            /** Ce fichier n'a
             *      - aucun traitement en attente
             *      - aucun traitement en cours d'execution
             *      - aucun traitement en file d'attente
             *
             *  Alors, on peut lancer au nouveau Traitement pour ce fichier
             */
            $reporttreatmentresult = $this->createNewTreatment();
            $this->execTreatment($reporttreatmentresult);
        } else {
            // On récupère les traitements en cours de ce fichier
            //$waiting_report_treatments = $this->reportTreatmentResultsWaiting;

            //\Log::info("Fichier ".$this->id.", aucun traitement en attente. En execution:".$this->reportTreatmentResultsRunning()->count().", En File:".$this->reportTreatmentResultsQueued()->count());
            if ( $this->reportTreatmentResultsWaiting()->count() > 0 ) {
                $waiting_report_treatment = $this->reportTreatmentResultsWaiting()->first();
                $this->execTreatment($waiting_report_treatment);
            }
        }
    }

    public function execTreatment(ReportTreatmentResult $reporttreatmentresult) {
        \Log::info("execTreatment ".$reporttreatmentresult->id.", " . $reporttreatmentresult->workflowstep->code->value);
        if ( $reporttreatmentresult->workflowstep->code === TreatmentStepCode::DOWNLOADFILE ) {
            $this->collectFile($reporttreatmentresult, false);
        } elseif ( $reporttreatmentresult->workflowstep->code === TreatmentStepCode::IMPORTFILE ) {
            $this->importLastCollectedFile($reporttreatmentresult, false);
        } elseif ( $reporttreatmentresult->workflowstep->code === TreatmentStepCode::MERGECOLUMNS ) {
            $this->mergeColumns($reporttreatmentresult);
        } elseif ( $reporttreatmentresult->workflowstep->code === TreatmentStepCode::MERGEROWS ) {
            $this->mergeRows($reporttreatmentresult, false);
        } elseif ( $reporttreatmentresult->workflowstep->code === TreatmentStepCode::NOTIFYFILE ) {
            $this->notifyLastCollectedFile($reporttreatmentresult, false);
        }
    }

    public function collectFile(ReportTreatmentResult $reporttreatmentresult = null, $dispatch = false) {
        $reportfileaccess = $this->getActiveReportFileAccess();
        if ( is_null( $reporttreatmentresult ) ) $reporttreatmentresult = $this->createNewTreatment();

        /*if ($dispatch) {
            //CollectReportFileJob::dispatchSync($reporttreatmentresult, $reportfileaccess);
            //Queue::push(new CollectReportFileJob($reporttreatmentresult, $reportfileaccess));
            dispatch(new CollectReportFileJob($reporttreatmentresult, $reportfileaccess))->onQueue(QueueEnum::DOWNLOADFILES->value);
        } else {
            $reportfileaccess->executeTreatment($reporttreatmentresult);
        }*/

        $reportfileaccess->executeTreatment($reporttreatmentresult);
    }

    public function importLastCollectedFile(ReportTreatmentResult $reporttreatmentresult, $dispatch = false) {
        $latestcollectedreportfile = $this->latestCollectedReportFile;

        /*if ($dispatch) {
            //ImportReportFileJob::dispatch($reporttreatmentresult, $latestcollectedreportfile);
            //Queue::push(new ImportReportFileJob($reporttreatmentresult, $latestcollectedreportfile));
            dispatch(new ImportReportFileJob($reporttreatmentresult, $latestcollectedreportfile))->onQueue(QueueEnum::IMPORTFILES->value);
        } else {
            $latestcollectedreportfile->importToDb($reporttreatmentresult);
        }*/
        $latestcollectedreportfile->importToDb($reporttreatmentresult);
    }

    public function prepareFormatting(ReportTreatmentResult $reporttreatmentresult) {
        $latestcollectedreportfile = $this->latestCollectedReportFile;
        $reporttreatmentresult->addStep(TreatmentStepCode::PREPAREFORMATTING, "Formattage fichier " . $latestcollectedreportfile->local_file_name,CriticalityLevelEnum::HIGH,true);
        $reporttreatmentresult->setNextWorkflowStep();
    }

    public function mergeColumns(ReportTreatmentResult $reporttreatmentresult) {
        $latestcollectedreportfile = $this->latestCollectedReportFile;
        $latestcollectedreportfile->mergeColumns($reporttreatmentresult);
    }

    public function mergeRows(ReportTreatmentResult $reporttreatmentresult) {
        $latestcollectedreportfile = $this->latestCollectedReportFile;
        $latestcollectedreportfile->mergeRows($reporttreatmentresult);
    }

    public function formatLastCollectedFileRows(ReportTreatmentResult $reporttreatmentresult, $dispatch = false) {
        $latestcollectedreportfile = $this->latestCollectedReportFile;
        /*if ($dispatch) {
            //Queue::push(new FormatReportFileJob($reporttreatmentresult, $latestcollectedreportfile));
            dispatch(new FormatReportFileJob($reporttreatmentresult, $latestcollectedreportfile))->onQueue(QueueEnum::FORMATFILES->value);
        } else {
            $latestcollectedreportfile->formatFileRows($reporttreatmentresult);
        }*/
        $latestcollectedreportfile->formatFileRows($reporttreatmentresult);
    }

    public function mergeFormattedValuesLastCollectedFile(ReportTreatmentResult $reporttreatmentresult, $dispatch = false) {
        $latestcollectedreportfile = $this->latestCollectedReportFile;
        if ($dispatch) {
            //FormatReportFileJob::dispatch($reporttreatmentresult, $latestcollectedreportfile);
            //Queue::push(new FormatReportFileJob($reporttreatmentresult, $latestcollectedreportfile));
            dispatch(new MergeReportFileFormattedRowsJob($reporttreatmentresult, $latestcollectedreportfile));
        } else {
            $latestcollectedreportfile->mergeLinesFormattedValues($reporttreatmentresult)->onQueue(QueueEnum::FORMATFILES->value);
        }
    }

    public function notifyLastCollectedFile(ReportTreatmentResult $reporttreatmentresult, $dispatch = false) {
        $latestcollectedreportfile = $this->latestCollectedReportFile;
        if ($dispatch) {
            //NotifyReportJob::dispatch($reporttreatmentresult, $latestcollectedreportfile);
            //Queue::push(new NotifyReportJob($reporttreatmentresult, $latestcollectedreportfile));
            dispatch(new NotifyReportJob($reporttreatmentresult, $latestcollectedreportfile))->onQueue(QueueEnum::NOTIFYFILES->value);
        } else {
            $latestcollectedreportfile->notify($reporttreatmentresult);
        }
    }

    /**
     * Create a new treatment (ReportTreatmentResult) for this file.
     * @return ReportTreatmentResult|null
     */
    private function createNewTreatment(): ?ReportTreatmentResult
    {
        if ( $this->reportTreatmentResultsWaiting()->count() === 0 && $this->reportTreatmentResultsRunning()->count() === 0 && $this->reportTreatmentResultsQueued()->count() === 0 ) {
            /** Ce fichier n'a
             *      - aucun traitement en attente
             *      - aucun traitement en cours d'execution
             *      - aucun traitement en file d'attente
             *
             *  Alors, on peut lancer au nouveau Traitement pour ce fichier
             */
            return $this->addReportTreatmentResult($this->report, "Traitement du fichier " . $this->name);
        } else {
            return null;
        }
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
