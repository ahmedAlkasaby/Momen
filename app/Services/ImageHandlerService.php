<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageHandlerService
{
   
    public function uploadImage( $folder = 'images', $request,$width = 800, $height = 600)
    {
        $manager = new ImageManager(new Driver());

        $imageFile = $request->file('image');

        $realPath = $imageFile->getRealPath();
        $image = $manager->read($realPath);

        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $imageName = time() . '.webp';
        $imagePath = 'uploads/' . $folder . '/' . $imageName;

        $image->toWebp(quality: 60)
              ->save(public_path($imagePath));

        return $imagePath;
    }





    public function deleteImage($path): void
    {
        if (!$path) return;
        if(!file_exists(public_path($path))) return;
        unlink(public_path($path));
    }

    public function editImage($request, $obj, $folder)
    {
        $imgUrl = $obj->image ?? "";
        if ($request->hasFile('image') && $request->image!= $obj->image) {
            $this->deleteImage($obj->image);
            $imgUrl = $this->uploadImage($folder, $request);
        }
        return $imgUrl;
    }
}
