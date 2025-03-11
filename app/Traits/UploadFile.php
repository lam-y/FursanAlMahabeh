<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait UploadFile
{
    public static function uploadFile($path, $file)
    {
        $name = null;

        if(gettype($file) == "string"){
            if(preg_match('/^data:image\/(\w+);base64,/', $file)){
                // استخراج البيانات Base64 بعد جزء الـ "data:image/png;base64,"
                list($type, $data) = explode(';', $file);
                list(, $data) = explode(',', $data);

                // فك تشفير Base64
                $file = base64_decode($data);
                $extension = explode('/', $type)[1];
                $name = 'IMG-' . md5(time()) . '.' . $extension;

                if (!File::isDirectory(storage_path('app/public/' . $path))) {
                    File::makeDirectory(storage_path('app/public/' . $path), 0777, true, true);
                }

                Storage::put('public/' . $path. $name, $file);
            }
            else{
                return $file;
            }
        }

        elseif($file) {
            if (! File::isDirectory(storage_path('app/public/' . $path))) {
                File::makeDirectory(storage_path('app/public/' . $path), 0777, true, true);
            }

            $extension = strtolower($file->getClientOriginalExtension());
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $name = $originalFileName . '-' . md5(time()) . '.' . $extension;

            Storage::putFileAs('public/'.$path, $file, $name);
        }
        return $name;
    }
}
