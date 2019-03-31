<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LangTranslation extends BaseModel
{
    protected $table = 'LangTranslation';
    protected $primaryKey = 'idTranslation';
    protected $fillable = ['code', 'idUserCreate'];

    public function texts()
    {
        return self::join('LangText', function ($join) {
            $join->on('LangText.idTranslation', '=', 'LangTranslation.idTranslation');
        })
        ->join('Lang', function ($join) {
            $join->on('Lang.idLang', '=', 'LangText.idLang');
        })
        ->where('LangTranslation.idTranslation', $this->idTranslation)
        ->select(
            'Lang.code',
            'Lang.name',
            'Lang.idLang',
            'LangText.idLangText',
            'LangText.idTranslation',
            'LangText.text'
        );
    }
}
