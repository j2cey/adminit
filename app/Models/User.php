<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'name',
        'email',
        'password',
    ];*/
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    #region Validation Tools

    public static function defaultRules() {
        return [
            'name' => ['required','string',],
        ];
    }
    public static function createRules()  {
        return array_merge(self::defaultRules(), [
            'email' => ['required',
                'unique:users,email,NULL,id',
            ],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'email' => ['required',
                'unique:users,email,'.$model->id.',id',
                ]
        ]);
    }
    public static function validationMessages() {
        return [];
    }

    #region Eloquent Relationships
}
