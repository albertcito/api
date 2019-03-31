<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Application extends BaseModel
{
    protected $table  = 'Application';
    protected $primaryKey = 'idApplication';

    protected $fillable = ['idApplication','name', 'description', 'idUserCreate'];
    protected $hidden = ['created_at','updated_at'];
}
