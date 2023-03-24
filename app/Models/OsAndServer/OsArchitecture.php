<?php

namespace App\Models\OsAndServer;

use App\Models\Status;
use App\Models\BaseModel;
use App\Traits\Code\HasCode;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class OsArchitecture
 * @package App\Models\OsAndServer\OsArchitecture
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
 *
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static OsArchitecture first()
 */
class OsArchitecture extends BaseModel implements Auditable
{
    use HasFactory, HasCode, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'name' => ['required'],
            'code' => ['required','unique:os_architectures,code,NULL,id'],
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function updateRules($model)
    {
        return array_merge(self::defaultRules(), [
            'code' => ['required','unique:os_architectures,code,'.$model->id.',id'],
        ]);
    }

    public static function messagesRules()
    {
        return [
            'name.required' => "Prière de renseigner le name",
            'code.required' => "Prière de renseigner le code",
            'code.unique' => "Le code doit être unique",
        ];
    }

    #region Eloquent Relationships



    #endregion

    #region Custom Functions

    /**
     * Crée (et stocker dans la base de données) un nouvel objet de type OsArchitecture
     * @param $name
     * @param $code
     * @param null|Status $status
     * @param string|null $description
     * @return OsArchitecture
     */
    public static function createNew($name, $code, Status $status = null, string $description = null): OsArchitecture
    {
        $status = is_null($status) ? Status::default()->first() : $status;

        $accessaccount = OsArchitecture::create([
            'name' => $name,
            'code' => $code,
            'description' => $description,
        ]);

        $accessaccount->status()->associate($status)->save();

        return $accessaccount;
    }

    /**
     * Modifie cet Objet
     * @param $name
     * @param $code
     * @param Status|null $status
     * @param string|null $description
     * @return $this
     */
    public function updateOne($name, $code, Status $status = null, string $description = null): OsArchitecture
    {
        $this->name = $name;
        $this->code = $code;
        $this->description = $description;

        if ( ! is_null($status) ) {
            $this->status()->associate($status)->save();
        }

        $this->save();

        return $this;
    }
}
