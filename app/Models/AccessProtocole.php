<?php

namespace App\Models;

use App\Traits\Code\HasCode;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Contracts\AccessProtocole\IProtocole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AccessProtocole
 * @package App\Models\AccessProtocole
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $name
 * @property string $code
 * @property IProtocole $protocole_class
 *
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AccessProtocole extends BaseModel implements Auditable

{
    use HasFactory, HasCode, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'name' => ['required'],
            'code' => ['required','unique:access_protocoles,code,NULL,id'],
            'protocole_class' => ['required'],
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function updateRules($model)
    {
        return array_merge(self::defaultRules($model), [
            'code' => ['required','unique:access_protocoles,code,'.$model->id.',id'],
        ]);
    }

    public static function messagesRules()
    {
        return [
            'name.required' => "Prière de renseigner le Nom",
            'code.required' => "Prière de renseigner le Code",
            'code.unique' => "Ce Code est déjà utilisé",
            'protocole_class.required' => "Prière de renseigner le chemin de la classe du Protocole",
        ];
    }

    #region Scopes

    public function scopeFtp($query) {
        return $query
            ->where('code', "ftp");
    }

    public function scopeSftp($query) {
        return $query
            ->where('code', "sftp");
    }

    #endregion

    /**
     * @return IProtocole
     */
    public function innerprotocole() {
        return $this->protocole_class;
    }

    /**
     * Crée (et stocke dans la base de données) un nouveau Protocole d'accès
     * @param string $name Nom du Protocole
     * @param string $code Code du Protocole
     * @param string $protocole_class Class du InnerProtocole lié
     * @param Status|null $status Statut
     * @param string|null $description Description
     * @return AccessProtocole
     */
    public static function createNew(string $name, string $code, string $protocole_class, Status $status = null, string $description = null): AccessProtocole
    {
        $status = is_null($status) ? Status::default()->first() : $status;

        $accessprotocole = AccessProtocole::create([
            'name' => $name,
            'code' => $code,
            'protocole_class' => $protocole_class,
            'description' => $description,
        ]);

        $accessprotocole->status()->associate($status)->save();

        return $accessprotocole;
    }

    /**
     * Met à jour (et stocke dans la base de données) ce Protocole d'accès
     * @param string $name Nom du Protocole
     * @param string $code Code du Protocole
     * @param string $protocole_class Class du InnerProtocole lié
     * @param Status|null $status Statut
     * @param string|null $description Description
     * @return $this
     */
    public function updateOne(string $name, string $code, string $protocole_class,Status $status = null, string $description = null): AccessProtocole
    {
        $this->name = $name;
        $this->code = $code;
        $this->protocole_class = $protocole_class;
        $this->description = $description;

        if ( ! is_null($status) ) {
            $this->status()->associate($status);
        }

        $this->save();

        return $this;
    }
}
