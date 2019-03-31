<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Device extends BaseModel
{
    protected $table  = 'Device';
    protected $primaryKey = 'idDevice';

    protected $fillable = [
        'idCompany',
        'name',
        'type',
        'description',
        'idUserCreate'
    ];
    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function slots()
    {
        return $this->hasMany('App\DeviceSlot', 'idDevice');
    }

    public static function isAuthorized($idCompany, $idDevice)
    {
        $deviceExist = parent::where([
            'idDevice' => $idDevice,
            'idCompany' => $idCompany,
        ])->count();
        return ($deviceExist == 1);
    }
}
