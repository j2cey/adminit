<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AccessAccount
 * @package App\Models\AccessAccount
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $login
 * @property string $pwd
 * @property string $email
 * @property string $username
 *
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AccessAccount extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'login' => ['required'],
            'email' => ['required','email'],
            'username' => ['required','unique:access_accounts,username,NULL,id'],
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [
            'pwd' => ['required'],
        ]);
    }

    public static function updateRules($model)
    {
        return array_merge(self::defaultRules(), [
            'username' => ['required','unique:access_accounts,username,'.$model->id.',id'],
        ]);
    }

    public static function messagesRules()
    {
        return [
            'login.required' => "Prière de renseigner le login",
            'pwd.required' => "Prière de renseigner le mot de passe",
            'email.required' => "Prière de renseigner l'adresse mail",
            'email.email' => "L'adresse mail n'est pas valide",
        ];
    }

    #region Eloquent Relationships



    #endregion

    #region Custom Functions

    /**
     * Sert à créer (et stocker dans la base de données) un nouvel objet de type AccessAccount
     * @param $login
     * @param null $description
     * @return AccessAccount
     */
    public static function createNew($login, $pwd, $email, $username, Status $status = null, $description = null): AccessAccount
    {
        $status = is_null($status) ? Status::default()->first() : $status;

        $accessaccount = AccessAccount::create([
            'login' => $login,
            'pwd' => $pwd,
            'email' => $email,
            'username' => $username,
            'description' => $description,
        ]);

        $accessaccount->status()->associate($status)->save();

        return $accessaccount;
    }

    public function updateOne($login, $pwd, $email, $username, Status $status = null, $description = null): AccessAccount
    {
        $this->login = $login;
        $this->pwd = $pwd;
        $this->email = $email;
        $this->username = $username;
        $this->description = $description;

        if ( ! is_null($status) ) {
            $this->status()->associate($status)->save();
        }

        $this->save();

        return $this;
    }
}

