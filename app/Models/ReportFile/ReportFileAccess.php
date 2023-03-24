<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Str;
use App\Traits\Code\HasCode;
use Illuminate\Support\Carbon;
use App\Models\Access\AccessAccount;
use App\Models\Access\AccessProtocole;
use Illuminate\Support\Facades\Storage;
use App\Models\OsAndServer\ReportServer;
use App\Models\RetrieveAction\RetrieveAction;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Models\RetrieveAction\RetrieveActionType;
use App\Models\RetrieveAction\SelectedRetrieveAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\SelectedRetrieveAction\HasSelectedRetrieveActions;
use App\Contracts\SelectedRetrieveAction\IHasSelectedRetrieveActions;

/**
 * Class ReportFileAccess
 * @package App\Models\ReportFile
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $name
 * @property int $port
 * @property string|null $code
 * @property string|null $description
 *
 * @property integer|null $report_file_id
 * @property integer|null $access_account_id
 * @property integer|null $report_server_id
 * @property integer|null $access_protocole_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 *
 * @property ReportFile $reportfile
 * @property AccessAccount $accessaccount
 * @property ReportServer $reportserver
 * @property AccessProtocole $accessprotocole
 *
 * @method static ReportFileAccess first()
 */
class ReportFileAccess extends BaseModel implements IHasSelectedRetrieveActions
{
    use HasFactory, HasSelectedRetrieveActions, HasCode, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $with = ['selectedretrieveactions'];

    public static function defaultRules() {
        return [
            'reportfile' => ['required'],
            'accessaccount' => ['required'],
            'reportserver' => ['required'],
            'accessprotocole' => ['required'],
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
            'reportfile.required' => "Prière de renseigner le Fichier",
            'accessaccount.required' => "Prière de renseigner le Compte",
            'reportserver.required' => "Prière de renseigner le Serveur",
            'accessprotocole.required' => "Prière de renseigner le Protocole d'accès",
        ];

    }

    #endregion

    #region Eloquent Relationships

    public function reportfile() {
        return $this->belongsTo(ReportFile::class, 'report_file_id');
    }

    public function accessaccount(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AccessAccount::class, 'access_account_id');
    }

    public function reportserver() {
        return $this->belongsTo(ReportServer::class, 'report_server_id');
    }

    public function accessprotocole() {
        return $this->belongsTo(AccessProtocole::class, 'access_protocole_id');
    }

    public function selectedretrieveactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SelectedRetrieveAction::class,'report_file_access_id');
    }

    #endregion

    #region Accessors & Mutators

    #endregion


    #region Custom Functions

    /**
     * Crée (et stocke dans la base de données) un nouvel objet ReportFileAccess
     * @param ReportFile $reportfile Le Fichier
     * @param AccessAccount $accessaccount Le Compte
     * @param ReportServer $reportserver Le Serveur
     * @param AccessProtocole $accessprotocole Le Protocole d'accès
     * @param string|null $name Le Nom de l'accès
     * @param int|null $port Le Port d'accès
     * @param string|null $code Le Code de l'accès
     * @param Status|null $status Le Statut
     * @param string|null $description Description
     * @return ReportFileAccess
     */
    public static function createNew(ReportFile $reportfile, AccessAccount $accessaccount, ReportServer $reportserver, AccessProtocole $accessprotocole, string $name = null, int $port = null, string $code = null, Status $status = null, string $description = null): ReportFileAccess
    {
        $reportfileaccess = ReportFileAccess::create([
            'name' => $name,
            'port' => $port ?? $accessprotocole->default_port,
            'code' => $code,
            'description' => $description,
        ]);

        // associate ReportFile
        $reportfileaccess->reportfile()->associate($reportfile);

        // associate ReportServer
        $reportfileaccess->reportserver()->associate($reportserver);

        // associate AccessAccount
        $reportfileaccess->accessaccount()->associate($accessaccount);

        // associate AccessProtocole
        $reportfileaccess->accessprotocole()->associate($accessprotocole);

        // associate Status
        $reportfileaccess->status()->associate($status);

        // save le new object
        $reportfileaccess->save();

        // set default actions
        $reportfileaccess->setDefaultSelectedRetrieveActions();

        return $reportfileaccess;
    }

    /**
     * Met à jour (et modifie dans la base de données) l'objet ReportFileAccess
     * @param ReportFile $reportfile Le Fichier
     * @param AccessAccount $accessaccount Le Compte
     * @param ReportServer $reportserver Le Serveur
     * @param AccessProtocole $accessprotocole Le Protocole d'accès
     * @param string|null $name Le Nom de l'accès
     * @param int|null $port Le Port d'accès
     * @param string|null $code Le Code de l'accès
     * @param Status|null $status Le Statut
     * @param string|null $description Description
     * @return $this
     */
    public function updateOne(ReportFile $reportfile, AccessAccount $accessaccount, ReportServer $reportserver, AccessProtocole $accessprotocole, string $name = null, int $port = null, string $code = null, Status $status = null, string $description = null): ReportFileAccess
    {
        $this->name = $name;
        $this->port = $port ?? $accessprotocole->default_port;
        $this->code = $code;
        $this->description = $description;

        // associate ReportFile
        $this->reportfile()->associate($reportfile);

        // associate ReportServer
        $this->reportserver()->associate($reportserver);

        // associate AccessAccount
        $this->accessaccount()->associate($accessaccount);

        // associate AccessProtocole
        $this->accessprotocole()->associate($accessprotocole);

        // associate Status
        $this->status()->associate($status);

        // save le new object
        $this->save();

        // save le new object
        $this->save();

        return $this;
    }


    private function setDefaultSelectedRetrieveActions() {
        if ( count($this->reportfile->selectedretrieveactions) === 0 ) {
            // on affecte les atcions par
            $this->setDefaultActionsFromSettings();
        } else {
            $this->selectedretrieveactions()->saveMany(
                $this->reportfile->selectedretrieveactions
            );
        }
        $this->refresh();
    }

    public function dissociateSelectedActions(SelectedRetrieveAction $selectedretrieveaction): ?bool
    {
        $selectedretrieveaction->reportfileaccess()->dissociate()->save();

        return true;
    }

    public function setFormalizedCodeAndName() {
        //$this->normalizeCodeField();
        self::setCodeIfNotExists($this);
        if ( is_null($this->name) ) {
            $this->name = $this->code;
        }
    }

    public function executeTreatment() {

        // 1. Définir le disk en fonction du protocole
        //$remoteDisk = $this->getDisk();

        // 2. Récupère l'action à axécuter pour la Récupération du fichier (retrieve_mode)
        $retrievemode_action = $this->getRetrieveModeAction();
        //$retrievemode_action->action_class::execRetrieveAction($this->reportfile);
        return $retrievemode_action;

        // 3. Récupère l'action à axécuter après la Récupération du fichier (to_perform_after_retrieving)

    }

    private function getDisk(): Filesystem {
        return $this->accessprotocole->innerprotocole()::getDisk($this->accessaccount, $this->reportserver,21);// $this->getDisk(21);
    }

    private function getRetrieveModeAction(): ?RetrieveAction
    {
        $retrievemode_action = $this->selectedretrieveactions()->with( [ 'retrieveaction' => function( $query ) {
            $query->with(['retrieveactiontype' => function () {
                RetrieveActionType::retrieveMode();
            }]);
        }])->first();
        return $retrievemode_action->retrieveaction ?? null;
    }

    private function getToPerformAfterRetrievingAction(): ?RetrieveAction
    {
        $retrievemode_action = $this->selectedretrieveactions()->with( [ 'retrieveaction' => function( $query ) {
            $query->with(['retrieveactiontype' => function () {
                RetrieveActionType::retrieveMode();
            }]);
        }])->first();
        return $retrievemode_action->retrieveaction ?? null;
    }






    public function renameRemoteFile(){
        $file_name = "laravel_test" . "." . $this->reportfile->extension;
        $remotedir_path = "/";
        $file_path_from = $remotedir_path . "/" . $file_name;
        $file_path_to = $remotedir_path . "/" . "laravel_test2" . "." . $this->reportfile->extension;

        $remoteDisk = $this->getDisk();

        $result = $remoteDisk->rename($file_path_from, $file_path_to);

        dd($result);
    }

    public function renameRemoteFileStart(){

    }

    public function renameRemoteFileEnd(){

    }

    public function deleteRemoteFile(){
        $file_name = "laravel_test" . "." . $this->reportfile->extension;
        $remotedir_path = "/";
        $file_path_from = $remotedir_path . "/" . $file_name;

        $remoteDisk = $this->getDisk();

        $result = $remoteDisk->delete($file_path_from);

        dd($result);
    }

    public function appendRemoteFile(){
        $file_name = "laravel_test" . "." . $this->reportfile->extension;
        $remotedir_path = "/";
        $file_path_from = $remotedir_path . "/" . $file_name;
        $text_to_append = 'onof';

        $remoteDisk = $this->getDisk();

        $result = $remoteDisk->append($file_path_from,$text_to_append);

        dd($result);
    }

    public function prependRemoteFile(){
        $file_name = "laravel_test" . "." . $this->reportfile->extension;
        $remotedir_path = "/";
        $file_path_from = $remotedir_path . "/" . $file_name;
        $text_to_prepend = 'gourde';

        $remoteDisk = $this->getDisk();

        $result = $remoteDisk->prepend($file_path_from,$text_to_prepend);

        dd($result);
    }

    public function downloadFile() {
        //$this->renameRemoteFile();
        //$this->deleteRemoteFile();
        //$this->appendRemoteFile();
        //$this->prependRemoteFile();
        $this->downloadByWildcard();
        $file_name = "laravel_t.*"."." . $this->reportfile->extension; //$this->reportfile->name . $this->reportfile->extension; //
        $remotedir_path = "/";
        $file_path_from = $remotedir_path . "/" . $file_name;

        $local_file_name = md5($this->reportfile->name . '_' . time()) . '.' . $this->reportfile->extension;

        $port = 21;

        $remoteDisk = $this->getDisk();


        try{
            $result = Storage::disk('public')->put('/collectedreportfiles/'. $local_file_name, $remoteDisk->readStream($file_path_from));
        }
        catch (\Exception $e){
            dd($e->getMessage());
        }


        //$result = Storage::disk('ftp')->rename($file_path_from, $file_path_to);
        //$result = Storage::disk('public')->put('/collectedreportfiles/'. $file_name, Storage::disk('ftp')->readStream(file_path_from));

        // Action(s) après récupération

        // renommage du fichier distant

        // suppression du fichier distant

        // append au nom du fichier distant (après)

        // prepend au nom du fichier distant (avant)

        // modification de l'extension du fichier distant

        dd($result);
    }

    public function downloadByWildcard(){

        $file_name = "laravel_t.*"."." . $this->reportfile->extension;
        $remotedir_path = "/";
        $file_path_from = $remotedir_path . "/" . $file_name;

        $remoteDisk = $this->getDisk();
        $wilcard = "laravel_*". '.' . $this->reportfile->extension;
        $files = $remoteDisk->allFiles();
        $nbrfiles = 0;

        foreach ($files as $file){

            if(Str::is($file,$wilcard)){
                $nbrfiles += 1;
                $local_file_name = md5($file . '_' . time()) . '.' . $this->reportfile->extension;
                $result = Storage::disk('public')->put('/collectedreportfiles/'. $local_file_name, $remoteDisk->readStream($remotedir_path . "/" . $file));
            }

        }
        dd($nbrfiles);
    }



    protected static function boot(){
        parent::boot();

        // Pendant la création de ce Model
        static::creating(function ($model) {
            $model->setFormalizedCodeAndName();
        });

        // Pendant la modification de ce Model
        static::updating(function ($model) {
        });
    }

    #endregion
}
