<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\LangText;

class ActCIImage extends Model
{
    protected $table = 'ActCIImage';
    protected $primaryKey = 'idCIImage';
    protected $fillable = [
        'idActivityChooseImage',
        'idImage'
    ];
}
