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
     * Sert à créer (et stocker dans la base de données) un nouvel objet de type ReportFileType
     * @param OsServer $osserver
     * @param $name
     * @param $ip_address
     * @param $domain_name
     * @param Status $status
     * @param null $description
     * @return ReportServer
     */
    public static function createNew(OsServer $osserver, $name, $ip_address, $domain_name, Status $status = null, $description = null) : ReportServer
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

    public function updateOne(OsServer $osserver, $name, $ip_address, $domain_name, Status $status = null, $description)
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
