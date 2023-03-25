<?php

namespace App\Models\OsAndServer;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ReportServer
 * @package App\Models\ReportServer
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
 * @property string $ip_address
 * @property string $domain_name
 * @property string|null $description
 *
 * @property OsServer $osserver
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static ReportServer first()
 */
class ReportServer extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    protected $guarded = [];


    #region Validation Rules

    public static function defaultRules() {
        return [
            'name' => ['required'],
            'ip_address' => [
                'required',
                'without_spaces'
            ],'domain_name' => [
                'required',
                'without_spaces'
            ],
            'osserver' => [
                'required',
            ]

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
            'name.required' => "Prière de renseigner le nom.",
            'ip_address.required' => "Prière de renseigner l'addresse ip. Celle-ci ne doit comporter aucun espace.",
            'ip_address.without_spaces' => "ne doit comporter aucun espace.",
            'domain_name.required' => "Prière de renseigner un nom de domaine.",
            'domain_name.without_spaces' => "le nom du domaine ne doit comporter aucun espace.",
            'osserver.required' => "Prière de renseigner le nom du système d'exploitation.",
        ];
    }

    #endregion

    public function OsServer() {
        return $this->belongsTo(OsServer::class, 'os_server_id');
    }

    #endregion

    #region Custom Functions

    /**
     * Crée (et stocke dans la base de données) un nouveau Serveur
     * @param Model|OsServer $osserver Le Système d'exploitation
     * @param string $name Le Nom du Serveur
     * @param string $ip_address L'adresse IP du Serveur
     * @param string $domain_name Le nom DNS du Serveur
     * @param Status|null $status Le Statut
     * @param string $description La Description
     * @return ReportServer
     */
    public static function createNew(Model|OsServer $osserver, string $name, string $ip_address, string $domain_name, Status $status = null, string $description = ""): ReportServer
    {
        $reportserver = ReportServer::create([
            'name' => $name,
            'ip_address' => $ip_address,
            'domain_name' => $domain_name,
            'description' => $description,
        ]);

        // Assignation de l'os du serveur
        $reportserver->osserver()->associate($osserver)->save();

        // associate status
        $osserver->status()->associate(is_null($status) ? Status::default()->first() : $status);

        return $reportserver;
    }

    /**
     * Met à jour (et stocke dans la base de données) ce Serveur
     * @param Model|OsServer $osserver Le Système d'exploitation
     * @param string $name Le Nom du Serveur
     * @param string $ip_address L'adresse IP du Serveur
     * @param string $domain_name Le nom DNS du Serveur
     * @param Status|null $status Le Statut
     * @param string $description La Description
     * @return $this
     */
    public function updateOne(Model|OsServer $osserver, string $name, string $ip_address, string $domain_name, Status $status = null, string $description = ""): ReportServer
    {
        $this->name = $name;
        $this->domain_name = $domain_name;
        $this->ip_address = $ip_address;
        $this->description = $description;

        //Assignation  du osserver
        $this->osserver()->associate($osserver);

        // associate status
        $this->status()->associate(is_null($status) ? $this->status : $status);

        $this->save();

        return $this;
    }
}
