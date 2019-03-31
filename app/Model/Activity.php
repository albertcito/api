<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\LangText;

class Activity extends BaseModel
{
    protected $table = 'Activity';
    protected $primaryKey = 'idActivity';
    protected $fillable = [
        'type',
        'idTitle',
        'idDescription',
        'json'
    ];

    public function title($idLang)
    {
        $title = LangText::where([
            'idTranslation' => $this->idTitle,
            'idLang' => $idLang
        ])->first();
        return $title->text;
    }

    public function description($idLang)
    {
        $description = LangText::where([
            'idTranslation' => $this->idDescription,
            'idLang' => $idLang
        ])->first();
        return $description->text ?? "";
    }
}
