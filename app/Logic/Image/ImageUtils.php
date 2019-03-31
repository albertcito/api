<?php

namespace App\Logic\Image;

class ImageUtils
{
    public static function getImageDirectory($idCompany, $idImage)
    {
        $imagePath = '/uploads/company/' . $idCompany . '/images/' . $idImage . '/';

        $basePath = base_path() . $imagePath;
        if (!is_dir($basePath)) {
            mkdir($basePath, 0775, true);
            chmod($basePath, 0775);
        }
        return $imagePath;
    }

    public static function getImagePath($idCompany, $idImage, $slug, $ext)
    {
        return  '/uploads/company/' . $idCompany
                . '/images/' . $idImage . '/'
                . $slug . '.' . $ext;
    }
}
