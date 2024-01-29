<?php


namespace App\Helpers;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UploadImageHelper
{
    public static string $defaultPath = 'assets'. DIRECTORY_SEPARATOR . 'images';

    public static function uploadAndGetPath($file, $storeTo = null): string
    {
        $storeTo = $storeTo ?: self::$defaultPath;

        // Check if $file is an instance of Illuminate\Http\UploadedFile
        if ($file instanceof UploadedFile) {
            // Generate a unique filename
            $filename = Str::random(8) . '.' . $file->getClientOriginalExtension();

            // Save the file to the specified directory
            $path = $file->storeAs($storeTo, $filename);

            // Return the path to the uploaded image
            return $path;
        }

        return '';
    }
}

