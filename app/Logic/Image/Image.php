<?php
namespace App\Logic\Image;

use Illuminate\Support\Facades\DB;
use App\Exceptions\MessageError;
use \App\Assets\{
    ImageUtils,
    InterventionImage
};

/**
 * Class to upload an image to a Company
 */
class Image
{
    /*
     * Create new Image row in DB
     *
     * @param $idCompant
     * @param array $fileToUpload file from HTML form
     * @return file
     */
    public function addImage(int $idCompany, $fileToUpload, string $guid = "")
    {
        try {
            DB::beginTransaction();

            $name = pathinfo($fileToUpload->getClientOriginalName(), PATHINFO_FILENAME);
            $fileSize = filesize($fileToUpload);

            $image =  \App\Image::create([
                'name' => $name,
                'idCompany' => $idCompany,
                'sourceImageSize' => $fileSize
            ])->fresh();

            $directory = ImageUtils::getImageDirectory($idCompany, $image->idImage);
            $image->path = $directory;
            $image->save();

            $absoluteDirectory = base_path() . $directory;
            $file = $this->uploadOriginalFile($image->idImage, $fileToUpload, $absoluteDirectory);

            if (strlen($guid) > 0) {
                $guidRow = \App\GUID::find($guid);
                if (!$guidRow) {
                    $guidRow = \App\GUID::create(['guid' => $guid])->fresh();
                }
                \App\ImageGUID::create([
                    'idImage' => $image->idImage,
                    'guid' => $guidRow->guid
                ])->fresh();
            }
            DB::commit();
            return $image;
        } catch (\Exception $error) {
            DB::rollback();
            throw new \Exception($error);
        }
    }

    /*
     * Upload file to Image
     *
     * @param $idImage
     * @param array $fileToUpload file from HTML form
     * @return file
     */
    private function uploadOriginalFile(int $idImage, $fileToUpload, string $directory, string $slugName = "-percent-1")
    {
        $imageFile = \App\ImageFile::create(['idImage' => $idImage])->fresh();
        $slug = $imageFile->idFile . $slugName;
        $interventionImage = new InterventionImage();
        $file = $interventionImage->upload($directory, $slug, $fileToUpload);
        $imageFile->ext    = $file['ext'];
        $imageFile->width  = $file['width'];
        $imageFile->height = $file['height'];
        $imageFile->size   = $file['size'];
        $imageFile->slug   = $slug;
        $imageFile->original = 1;
        $imageFile->save();
        return $imageFile;
    }

    /**
     * Create all the images files to this device.
     * @param  Eloquent $images  images set
     * @param  Eloquent $devices devices set
     * @return
     */
    public function toComplete($images, $devices)
    {
        foreach ($images as $image) {
            foreach ($devices as $device) {
                $slots = $device->slots()->get();
                foreach ($slots as $slot) {
                    $this->addFileSlot($image, $slot);
                }
            }
        }
    }

    public function addFileSlot($image, $slot)
    {
        $file = \App\ImageFile::getFileByPercent($image->idImage, $slot->percent)->first();
        if (!$file) {
            $originalFile = $image->originalFile();
            $directory = ImageUtils::getImageDirectory($image->idCompany, $image->idImage);
            $interventionImage = new InterventionImage();
            $fileArray = $interventionImage->resizeFile(
                base_path()  . $directory,
                $originalFile->slug,
                $originalFile->ext,
                $slot->percent
            );
            $fileArray['idImage'] = $image->idImage;
            $file = \App\ImageFile::create($fileArray)->fresh();
        }
        $imageFileSlot = \App\ImageFileSlot::where([
            'idImage' => $image->idImage,
            'idFile' => $file->idFile,
            'idSlot' => $slot->idSlot,
        ])->first();
        if (!$imageFileSlot) {
            \App\ImageFileSlot::create([
                'idImage' => $image->idImage,
                'idFile' => $file->idFile,
                'idSlot' => $slot->idSlot,
            ]);
        }
        return $file;
    }
}
