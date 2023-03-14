<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
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
 *
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AccessProtocole extends BaseModel implements Auditable

{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'name' => ['required'],
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function updateRules()
    {
        return array_merge(self::defaultRules(), [

        ]);
    }


    public static function messagesRules()
    {
        return [
            'name.required' => "Prière de renseigner le login",
        ];
    }


    /**
     * Sert à créer (et stocker dans la base de données) un nouvel objet de type AccessProtocole
     * @param $name
     * @param null $description
     * @return AccessProtocole
     */
    public static function createNew($name,Status $status = null, $description = null): AccessProtocole
    {
        $status = is_null($status) ? Status::default()->first() : $status;

        $accessprotocole = AccessProtocole::create([
            'name' => $name,
            'description' => $description,
        ]);

        $accessprotocole->status()->associate($status)->save();

        return $accessprotocole;
    }

    public function updateOne($name,Status $status = null, $description = null): AccessProtocole
    {
        $this->name = $name;
        $this->description = $description;

        if ( ! is_null($status) ) {
            $this->status()->associate($status)->save();
        }

        $this->save();

        return $this;
    }
}
