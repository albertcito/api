<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends BaseModel
{
    protected $table = 'Tag';
    protected $primaryKey = 'idTag';
    protected $fillable = ['name'];
}
