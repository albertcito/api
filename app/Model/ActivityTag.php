<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ActivityTag extends BaseModel
{
    protected $table = 'ActivityTag';
    protected $primaryKey = 'idActivityTag';
    protected $fillable = ['idActivity','idTag'];

    public static function searchTags($tag, $idActivity)
    {
        $query = DB::table('Tag')
        ->where('Tag.name', 'like', '%'. $tag .'%')
        ->whereNotIn('Tag.idTag', function ($query) use ($idActivity) {
            $query->select('ActivityTag.idTag')
                ->from('ActivityTag')
                ->where('ActivityTag.idActivity', $idActivity);
        });

        return $query;
    }
}
