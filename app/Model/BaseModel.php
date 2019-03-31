<?php

namespace App\Model;

use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use RevisionableTrait;
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
