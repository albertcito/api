<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LangText extends BaseModel
{
    protected $table = 'LangText';
    protected $primaryKey = 'idLangText';
    protected $fillable = [
        'idLang',
        'idTranslation',
        'text',
        'idUserCreate'
    ];
}
