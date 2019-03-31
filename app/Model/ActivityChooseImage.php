<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\LangText;

class ActivityChooseImage extends Model
{
    protected $table = 'ActivityChooseImage';
    protected $primaryKey = 'idActivityChooseImage';
    protected $fillable = [
        'idActivity',
        'idTranslation'
    ];
}
