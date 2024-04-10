<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FilesService {

    public function uploadFile($file, $filePath, $fileNewName)
    {
        return Storage::disk('public')->putFileAs($filePath, $file, $fileNewName);
    }

    function generateFileName($prefix = '', $extension = '')
    {
        $bytes = random_bytes(16);
        $name = bin2hex($bytes);
        if (! empty($prefix)) {
            $name = $prefix . $name;
        }
        if (! empty($extension)) {
            $name .= '.' . $extension;
        }

        return $name;
    }

    public function removeFile($path, $fileName, $addSeparator = true): bool
    {
        $addSeparator = ($addSeparator) ? '/' : '';
        return Storage::disk('public')->delete($path . $addSeparator . $fileName);
    }
}
