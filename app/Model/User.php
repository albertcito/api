<?php

namespace App\Model;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Venturecraft\Revisionable\RevisionableTrait;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, RevisionableTrait;

    protected $table = 'User';
    protected $primaryKey = 'idUser';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'validEmail',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function projects()
    {
        return $this->hasMany('App\Model\Project', 'idUserCreate');
    }

    public function devices()
    {
        return $this->hasMany('App\Model\Device', 'idUserCreate');
    }

    public static function boot()
    {
        parent::boot();
        if (\Auth::check()) {
            static::updating(function ($model) {
                $model->idUserUpdate = \Auth::User()->idUser;
            });

            static::creating(function ($model) {
                $model->idUserCreate = \Auth::User()->idUser;
            });
        }
    }
}
