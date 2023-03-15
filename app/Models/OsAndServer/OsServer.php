<?php

namespace App\Models\OsAndServer;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class OsServer
 * @package App\Models\OsAndServer
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $name
 * @property string|null $description
 *
 * @property integer|null $os_architecture_id
 * @property integer|null $os_family_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class OsServer extends BaseModel  implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $with = ["osarchitecture","osfamily"];

    public static function defaultRules() {
        return [
            'name' => ['required'],
            'osarchitecture' => ['required'],
            'osfamily' => ['required'],
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
            'osarchitecture.required' => "Prière de renseigner l'architecture",
            'osfamily.required' => "Prière de renseigner la famille",
        ];

    }

    #endregion

    #region Eloquent Relationships

    public function osarchitecture() {
        return $this->belongsTo(OsArchitecture::class, 'os_architecture_id');
    }

    public function osfamily() {
        return $this->belongsTo(OsFamily::class, 'os_family_id');
    }

    #endregion

    #region Accessors & Mutators

    #endregion


    #region Custom Functions

    /**
     * Crée (et stocker dans la base de données) un nouveau Système d'Exploitation
     * @param OsArchitecture $osarchitecture L'architecture de l'OS
     * @param OsFamily $osfamily Famille de l'OS
     * @param string $name Nom de l'OS
     * @param Status|null $status Statut de l'OS
     * @param string $description Description
     * @return OsServer
     */
    public static function createNew(OsArchitecture $osarchitecture, OsFamily $osfamily, string $name, Status $status = null, string $description = ""): OsServer
    {
        $osserver = OsServer::create([
            'name' => $name,
            'description' => $description,
        ]);

        // associate OsArchitecture
        $osserver->osarchitecture()->associate($osarchitecture);

        // associate OsFamily
        $osserver->osfamily()->associate($osfamily);

        // associate status
        $osserver->status()->associate(is_null($status) ? Status::default()->first() : $status);

        // save the new object
        $osserver->save();

        return $osserver;
    }

    /**
     * Met à jour (et stocker dans la base de données) ce Système d'Exploitation
     * @param OsArchitecture $osarchitecture L'architecture de l'OS
     * @param OsFamily $osfamily Famille de l'OS
     * @param string $name Nom de l'OS
     * @param Status|null $status Statut de l'OS
     * @param string $description Description
     * @return $this
     */
    public function updateOne(OsArchitecture $osarchitecture, OsFamily $osfamily, string $name, Status $status = null, string $description = ""): OsServer
    {
        $this->name = $name;
        $this->description = $description;

        // associate OsArchitecture
        $this->osarchitecture()->associate($osarchitecture);

        // associate OsFamily
        $this->osfamily()->associate($osfamily);

        // associate status
        $this->status()->associate(is_null($status) ? $this->status : $status);

        // save the object
        $this->save();

        return $this;
    }

    #endregion

    protected static function boot(){
        parent::boot();

        // Pendant la création de ce Model
        static::creating(function ($model) {
        });

        // Pendant la modification de ce Model
        static::updating(function ($model) {
        });
    }
}
