<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use App\Models\BaseModel;
use App\Traits\Code\HasCode;
use Illuminate\Support\Carbon;
use App\Models\AccessProtocole;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\OsAndServer\ReportServer;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
 * @property string|null $code
 * @property string|null $description
 *
 * @property bool $retrieve_by_name
 * @property bool $retrieve_by_wildcard
 *
 * @property integer $report_file_id
 * @property integer $report_server_id
 * @property integer $access_protocole_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 *
 * @property ReportFile $reportfile
 * @property ReportServer $reportserver
 * @property AccessProtocole $accessprotocole
 */
class ReportFileAccess extends BaseModel implements Auditable
{
    use HasFactory, HasCode, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $with = ["reportfiletype"];

    public static function defaultRules() {
        return [
            'reportfile' => ['required'],
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
            'reportserver.required' => "Prière de renseigner le Serveur",
            'accessprotocole.required' => "Prière de renseigner le Protocole d'accès",
        ];

    }

    #endregion

    #region Eloquent Relationships

    public function reportfile() {
        return $this->belongsTo(ReportFile::class, 'report_file_id');
    }

    public function reportserver() {
        return $this->belongsTo(ReportServer::class, 'report_server_id');
    }

    public function accessprotocole() {
        return $this->belongsTo(AccessProtocole::class, 'access_protocole_id');
    }

    #endregion

    #region Accessors & Mutators

    #endregion


    #region Custom Functions

    /**
     * Crée (et stocke dans la base de données) un nouvel objet de type ReportFileAccess
     * @param ReportFile $reportfile Le Fichier
     * @param ReportServer $reportserver Le Serveur
     * @param AccessProtocole $accessprotocole Le Protocole d'accès
     * @param string|null $name Le Nom de l'accès
     * @param string|null $code Le Code de l'accès
     * @param Status|null $status Le Statut
     * @param bool|null $retrieve_by_name Valeur déterminant si le fichier doit être récupéré par nom
     * @param bool|null $retrieve_by_wildcard Valeur déterminant si le fichier doit être récupéré par Wildcard
     * @param string $description Description
     * @return ReportFileAccess
     */
    public static function createNew(ReportFile $reportfile, ReportServer $reportserver, AccessProtocole $accessprotocole, string $name = null, string $code = null, Status $status = null, bool $retrieve_by_name = null, bool $retrieve_by_wildcard = null, string $description = ""): ReportFileAccess
    {
        $reportfileaccess = ReportFileAccess::create([
            'name' => $name,
            'code' => $code,
            'retrieve_by_name' => is_null($retrieve_by_name) ? $reportfile->retrieve_by_name : $retrieve_by_name,
            'retrieve_by_wildcard' => is_null($retrieve_by_wildcard) ? $reportfile->retrieve_by_wildcard : $retrieve_by_wildcard,
            'description' => $description,
        ]);

        // associate ReportFile
        $reportfileaccess->reportfile()->associate($reportfile);

        // associate ReportServer
        $reportfileaccess->reportserver()->associate($reportserver);

        // associate AccessProtocole
        $reportfileaccess->accessprotocole()->associate($accessprotocole);

        // associate Status
        $reportfileaccess->status()->associate($status);

        // save le new object
        $reportfileaccess->save();

        return $reportfileaccess;
    }

    /**
     * Met à jour (et modifie dans la base de données) un nouvel objet de type ReportFileAccess
     * @param ReportFile $reportfile Le Fichier
     * @param ReportServer $reportserver Le Serveur
     * @param AccessProtocole $accessprotocole Le Protocole d'accès
     * @param string|null $name Le Nom de l'accès
     * @param string|null $code Le Code de l'accès
     * @param Status|null $status Le Statut
     * @param bool $retrieve_by_name Valeur déterminant si le fichier doit être récupéré par nom
     * @param bool $retrieve_by_wildcard Valeur déterminant si le fichier doit être récupéré par Wildcard
     * @param string $description Description
     * @return $this
     */
    public function updateOne(ReportFile $reportfile, ReportServer $reportserver, AccessProtocole $accessprotocole, string $name = null, string $code = null, Status $status = null, bool $retrieve_by_name = false, bool $retrieve_by_wildcard = false, string $description = ""): ReportFileAccess
    {
        $this->name = $name;
        $this->code = $code;
        $this->retrieve_by_name = $retrieve_by_name;
        $this->retrieve_by_wildcard = $retrieve_by_wildcard;
        $this->description = $description;

        // associate ReportFile
        $this->reportfile()->associate($reportfile);

        // associate ReportServer
        $this->reportserver()->associate($reportserver);

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



    public function setFormalizedCodeAndName() {
        $this->normalizeCodeField();
        if ( is_null($this->name) ) {
            $this->name = $this->code;
        }
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
