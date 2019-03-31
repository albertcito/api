<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageFile extends BaseModel
{
    use SoftDeletes;

    protected $table  = 'ImageFile';
    protected $primaryKey = 'idFile';

    protected $fillable = [
        'idImage',
        'slug',
        'ext',
        'size',
        'width',
        'height',
        'original',
        'idUserCreate'
    ];
    protected $hidden = ['created_at','updated_at'];
    protected $dates = ['deleted_at'];

    public static function getFileByPercent(int $idImage, float $percent)
    {
        if ($percent == 1) {
            return ImageFile::where([
                'idImage' => $idImage,
                'original' => true
            ]);
        }
        $file = ImageFile
                ::join('ImageFileSlot', function ($join) use ($idImage) {
                    $join->on('ImageFileSlot.idFile', '=', 'ImageFile.idFile')
                        ->where('ImageFileSlot.idImage', '=', $idImage);
                })
                ->join('DeviceSlot', function ($join) use ($percent) {
                    $join->on('DeviceSlot.idSlot', '=', 'ImageFileSlot.idSlot')
                         ->where('DeviceSlot.percent', '=', $percent);
                })
                ->select('ImageFile.*');
        return $file;
    }
}
