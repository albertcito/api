<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use App\{
    ImageFile,
    Device
};
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends BaseModel
{
    use SoftDeletes;

    protected $table  = 'Image';
    protected $primaryKey = 'idImage';

    protected $fillable = [
        'idCompany',
        'idTranslation',
        'path',
        'sourceImageSize',
        'idUserCreate'
    ];
    protected $hidden = ['created_at', 'updated_at'];
    protected $dates = ['deleted_at'];

    public function files()
    {
        return $this->hasMany('App\ImageFile', 'idImage');
    }

    public function originalFile()
    {
        return $this->files()->where('original', 1)->first();
    }

    public function fileslot()
    {
        return $this->hasMany('App\ImageFileSlot', 'idImage');
    }

    public function tags()
    {
        return $this->hasManyThrough(
            'App\Tag',
            'App\ImageTag',
            'idImage',
            'idTag',
            'idImage',
            'idTag'
        );
    }

    public function filePreview()
    {
        $result = $this->files()->first();
        return $result;
    }

    public function devices()
    {
        $result = parent
                ::join('ProjectImage', function ($join) {
                    $join->on('ProjectImage.idImage', '=', 'Image.idImage');
                })
                ->join('ProjectDevice', function ($join) {
                    $join->on(
                        'ProjectDevice.idProject',
                        '=',
                        'ProjectImage.idProject'
                    );
                })
                ->join('Device', function ($join) {
                    $join->on('Device.idDevice', '=', 'ProjectDevice.idDevice');
                })
                ->join('DeviceSlot', function ($join) {
                    $join->on('DeviceSlot.idDevice', '=', 'Device.idDevice');
                })
                ->leftjoin('ImageFileSlot', function ($join) {
                    $join
                        ->on('ImageFileSlot.idSlot', '=', 'DeviceSlot.idSlot')
                        ->where('ImageFileSlot.idImage', '=', $this->idImage);
                })
                ->where('Image.idImage', $this->idImage)
                ->select(
                    'Device.*',
                    'Image.idImage',
                    DB::raw('(CASE WHEN count(DeviceSlot.idSlot) = count(ImageFileSlot.idSlot)
                        AND count(ImageFileSlot.idSlot) != 0 THEN 1 ELSE 0 END)
                        AS isComplete
                    ')
                )
                ->groupBy('Device.idDevice');
        return $result;
    }

    public function slots()
    {
        $slots = Device
            ::find($this->idDevice)
            ->leftjoin('DeviceSlot', function ($join) {
                $join->on('DeviceSlot.idDevice', '=', 'Device.idDevice');
            })
            ->leftjoin('ImageFileSlot', function ($join) {
                $join
                    ->on('ImageFileSlot.idSlot', '=', 'DeviceSlot.idSlot')
                    ->where('ImageFileSlot.idImage', '=', $this->idImage);
            })
            ->select(
                'DeviceSlot.*',
                'ImageFileSlot.idImageFileSlot',
                'ImageFileSlot.idFile'
            )
            ->where('Device.idDevice', $this->idDevice);
        return $slots;
    }

    public static function isAuthorized($idCompany, $idImage)
    {
        $imageExist = parent::where([
            'idImage' => $idImage,
            'idCompany' => $idCompany,
        ])->count();
        return ($imageExist == 1);
    }
}
