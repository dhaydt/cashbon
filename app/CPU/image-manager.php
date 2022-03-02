<?php

namespace App\CPU;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ImageManager
{
    public static function upload(string $dir, string $format, $image = null)
    {
        $dirSto = '/public/'.$dir;
        if (env('APP_ENV') == 'live') {
            if ($image != null) {
                $imageName = Carbon::now()->toDateString().'-'.uniqid().'.'.$format;
                if (!Storage::disk()->exists($dirSto)) {
                    Storage::disk()->makeDirectory($dirSto);
                }
                Storage::disk()->put($dirSto.$imageName, file_get_contents($image));
            } else {
                $imageName = 'def.png';
            }

            return $imageName;
        } else {
            if ($image != null) {
                $imageName = Carbon::now()->toDateString().'-'.uniqid().'.'.$format;
                if (!Storage::disk()->exists($dirSto)) {
                    Storage::disk()->makeDirectory($dirSto);
                }
                Storage::disk()->put($dirSto.$imageName, file_get_contents($image));
            } else {
                $imageName = 'def.png';
            }

            return $imageName;
        }
    }

    public static function update(string $dir, $old_image, string $format, $image = null)
    {
        $dirSto = '/public/'.$dir;
        if (Storage::disk()->exists($dirSto.$old_image)) {
            Storage::disk()->delete($dirSto.$old_image);
        }
        $imageName = ImageManager::upload($dir, $format, $image);

        return $imageName;
    }

    public static function delete($full_path)
    {
        if (env('APP_ENV') == 'live') {
            if (Storage::disk()->exists($full_path)) {
                Storage::disk()->delete($full_path);
            }

            return [
                'success' => 1,
                'message' => 'Removed successfully !',
            ];
        } else {
            $path = '/public'.$full_path;
            // dd($path);

            if (Storage::disk()->exists('/public'.$full_path)) {
                Storage::disk()->delete('/public'.$full_path);
            }

            return [
                'success' => 1,
                'message' => 'Removed successfully !',
            ];
        }
    }
}
