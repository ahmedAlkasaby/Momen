<?php

namespace App\Services;

class SettingsService
{
    public function updateImage($file, $oldImage, $folder)
    {
        if ($oldImage && file_exists(public_path($oldImage))) {
            unlink(public_path($oldImage));
        }

        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/' . $folder), $fileName);
        return 'uploads/' . $folder . '/' . $fileName;
    }
}
