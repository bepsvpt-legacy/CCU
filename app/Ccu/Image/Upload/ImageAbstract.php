<?php

namespace App\Ccu\Image\Upload;

use App\Ccu\Image\Image;
use Carbon\Carbon;
use File;
use Intervention\Image\Facades\Image as InterventionImage;

abstract class ImageAbstract
{
    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    protected $file;

    /**
     * The uploaded image unique hash.
     *
     * @var int
     */
    protected $hash;

    /**
     * @var \Intervention\Image\Image
     */
    protected $image;

    /**
     * @var Carbon
     */
    protected $uploaded_at;

    /**
     * Create a new UploadImageAbstract instance
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function __construct($file)
    {
        $this->file = $file;

        $this->hash = mt_rand(1000000000, 4294967295);

        $this->image = InterventionImage::make($this->file);

        $this->uploaded_at = Carbon::now();
    }

    /**
     * Crop the image.
     *
     * @param integer $width
     * @param integer $height
     * @param integer|null $x
     * @param integer|null $y
     * @return $this
     */
    public function cropImage($width, $height, $x = null, $y = null)
    {
        $this->image->crop($width, $height, $x, $y);

        return $this;
    }

    /**
     * Resize the image.
     *
     * @param integer $width
     * @param integer $height
     * @param bool $aspectRatio
     * @return $this
     */
    public function resizeImage($width, $height, $aspectRatio = true)
    {
        $this->image->resize($width, $height, function($constraint) use ($aspectRatio) {
            if ($aspectRatio) {
                $constraint->aspectRatio();
            }

            $constraint->upsize();
        });

        return $this;
    }

    /**
     * Save the image.
     *
     * @param string $path
     * @return $this
     */
    public function saveImage($path)
    {
        $this->createDirectoryIfNotExists($path);

        $this->image->save($path);

        return $this;
    }

    /**
     * Create the directory according to the path.
     *
     * @param $path
     */
    public function createDirectoryIfNotExists($path)
    {
        $dir = ends_with($path, '/') ? $path : substr($path, 0, strrpos($path, '/'));

        if ( ! File::exists($dir)) {
            File::makeDirectory($dir, 0770, true);
        }
    }

    /**
     * Create image record.
     *
     * @return Image
     */
    protected function createDatabaseRecord()
    {
        return Image::create([
            'hash' => $this->hash,
            'mime_type' => $this->image->mime(),
            'uploaded_at' => $this->uploaded_at->timestamp
        ]);
    }

    /**
     * Get the path to save image.
     *
     * @param bool $thumbnail
     * @return string
     */
    protected function getPath($thumbnail = false)
    {
        return image_path($this->hash, $this->uploaded_at->timestamp, $thumbnail);
    }

    /**
     * Handle the image upload process.
     *
     * @return bool
     */
    abstract public function handler();
}
