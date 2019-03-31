<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeviceSlot extends BaseModel
{
    protected $table = 'DeviceSlot';
    protected $primaryKey = 'idSlot';

    protected $fillable = [
        'idDevice',
        'name',
        'percent',
        'idUserCreate'
    ];
    protected $hidden = ['created_at','updated_at'];

    public static function getSlotImage($idImage, $idDevice)
    {
        $result = parent::
                where('DeviceSlot.idDevice', $idDevice)
                ->leftjoin('ImageFileSlot', function ($join) use ($idImage) {
                    $join->on('ImageFileSlot.idSlot', '=', 'DeviceSlot.idSlot')
                         ->where('ImageFileSlot.idImage', '=', $idImage);
                })
                ->select('DeviceSlot.*', 'ImageFileSlot.idFile')
                ->get();
        return $result;
    }
    public function imageFileSlot()
    {
        return \App\ImageFileSlot::where([
            'idSlot' => $this->idSlot
        ]);
    }
}
