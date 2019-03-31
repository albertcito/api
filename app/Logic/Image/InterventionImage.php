<?php

namespace App\Logic\Image;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use App\Assets\ImageUtils;

class InterventionImage
{
    public function upload(string $directory, string $slug, $fileupload) : array
    {
        $image = \Image::make($fileupload);
        $mediaType = $image->mime();
        $ext = explode('/', $mediaType)[1];
        $pathFile = $directory . $slug . "." .$ext;

        move_uploaded_file($fileupload, $pathFile);
        $this->optimizeImage($pathFile);
        chmod($pathFile, 0775);

        $width  = $image->width();
        $height = $image->height();
        $size = filesize($pathFile);

        return [
            'ext'    => $ext,
            'size'   => $size,
            'slug'   => $slug,
            'width'  => $width,
            'height' => $height
        ];
    }

    /**
     * Resize a file based in the parameters
     * @param  string $directory directory to save the image, and where is the original image
     * @param  string $slug      original image slug
     * @param  string $ext       original image extenstion
     * @param  float  $percent   percent to resize the image
     * @return array with the following values:
     * - slug
     * - ext
     * - width
     * - height
     * - size
     */
    public function resizeFile(string $directory, string $slug, string $ext, float $percent) : array
    {
        $originalPath = $this->getPath($directory, $slug, $ext);
        $image = \Image::make($originalPath);

        $imageFile = [
            'slug' => $percent . '-' . uniqid(),
            'ext' => $ext,
            'width' => intval($image->width()*$percent),
            'height' => intval($image->height()*$percent)
        ];

        $image->fit($imageFile['width'], $imageFile['height']);
        $newPath = $this->getPath($directory, $imageFile['slug'], $imageFile['ext']);
        $image->save($newPath);
        chmod($newPath, 0775);
        $imageFile['size'] = round($image->filesize());

        return $imageFile;
    }

    private function getPath($path, $slug, $ext): string
    {
        return $path . $slug . "." .$ext;
    }

    private function getSlug($idImageFile, $percent): string
    {
        return $idImageFile .'-percent-'. $percent;
    }

    private function optimizeImage($pathFile) : void
    {
        $pngQuant = new PNGQuant();
        $exit_code = $pngQuant->setImage($pathFile)
            ->setOutputImage($pathFile)
            ->overwriteExistingFile()
            ->setQuality(90, 100)
            ->execute();

        if ($exit_code) {
            $description = $pngQuant->getErrorTable()[(string) $exit_code];
            Bugsnag::notifyError('PNGQuant', 'Image not optimized', function ($report) use ($exit_code, $description) {
                $report->setSeverity('error');
                $report->setMetaData([
                  'pngQuant' => [
                      'exit_code' => $exit_code,
                      'description' => $description
                  ]
                ]);
            });
        }
    }
}
