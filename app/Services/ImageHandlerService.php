<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageHandlerService
{

    public function uploadImage($imageFile, $folder = 'images', $width = 800, $height = 600)
    {
        if (!$imageFile || !$imageFile->isValid()) {
            return null;
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read($imageFile->getRealPath());

        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $imageName = time() . '_' . uniqid() . '.webp';
        $pathInStorage = "$folder/$imageName";

        $encoded = $image->toWebp(quality: 60);
        Storage::disk('public')->put($pathInStorage, (string) $encoded);

        return '/storage/' . $pathInStorage;
    }





    public function deleteImage(?string $path): void
    {
        if (!$path) return;
    
        $relativePath = str_replace('/storage/', '', $path);
    
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }

    public function editImage($oldPath ,$imageFile, $folder)
    {
        $this->deleteImage($oldPath);
        return $this->uploadImage($imageFile, $folder); 
    }
}
