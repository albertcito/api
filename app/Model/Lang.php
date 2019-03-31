<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lang extends BaseModel
{
    protected $table = 'Lang';
    protected $primaryKey = 'idLang';
    protected $fillable = ['code', 'name', 'idUserCreate'];
}
