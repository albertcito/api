<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use App\DeviceSlot;

class ImageFileSlot extends BaseModel
{
    protected $table  = 'ImageFileSlot';
    protected $primaryKey = 'idImageFileSlot';
    protected $fillable = [
        'idImage',
        'idFile',
        'idSlot',
        'idUserCreate'
    ];

    protected $hidden = ['created_at','updated_at'];
    /*
     * If the image have all slot of the device with files
     *
     * @param $idImage
     * @param $idDevice
     * @return boolean
     */
    public static function isDeviceComplete($idImage, $idDevice)
    {
        $deviceFull = parent::
            where('ImageFileSlot.idImage', $idImage)
                ->join('DeviceSlot', 'DeviceSlot.idSlot', '=', 'ImageFileSlot.idSlot')
                ->join('Device', 'Device.idDevice', '=', 'DeviceSlot.idDevice')
                ->where('Device.idDevice', '=', $idDevice)
                ->groupBy('Device.name')
                ->count();
        $nslots = DeviceSlot::where('idDevice', $idDevice)->count();
        return $deviceFull == $nslots;
    }

    public static function updateFile($idImage, $idFile, $idSlot)
    {
        $imageFileSlot = parent
            ::where('idImage', $idImage)
            ->where('idSlot', $idSlot);

        if ($imageFileSlot->count()) {
            $imageFileSlot->update(['idFile'  => $idFile]);
        } else {
            $imageFileSlot = parent::create([
                'idImage' => $idImage,
                'idFile'  => $idFile,
                'idSlot'  => $idSlot
            ])->fresh();
        }

        $result = parent
                ::where('ImageFileSlot.idImage', $idImage)
                ->where('ImageFileSlot.idSlot', $idSlot)
                ->join('DeviceSlot', function ($join) use ($idSlot) {
                    $join->on('DeviceSlot.idSlot', '=', 'ImageFileSlot.idSlot')
                         ->where('DeviceSlot.idSlot', '=', $idSlot);
                })
                ->join('Device', 'Device.idDevice', '=', 'DeviceSlot.idDevice')
                ->select('ImageFileSlot.*', 'Device.idDevice')
                ->get();
        return $result[0];
    }
}
