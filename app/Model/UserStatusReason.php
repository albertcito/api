<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserStatusReason extends BaseModel
{
    protected $table  = 'UserStatusReason';
    protected $primaryKey = 'idUserStatusReason';

    protected $fillable = ['idUser', 'status','reason'];
    protected $hidden = ['created_at','updated_at'];
}
