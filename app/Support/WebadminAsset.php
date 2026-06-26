<?php

namespace App\Support;

class WebadminAsset
{
    public static function url(string $path): string
    {
        $base = trim(config('webadmin.asset_path', 'webadmin/assets'), '/');
        $path = ltrim($path, '/');

        if (str_starts_with($path, $base.'/')) {
            return asset($path);
        }

        return asset($base.'/'.$path);
    }

    public static function style(string $path): string
    {
        return self::url($path.'.css');
    }

    public static function script(string $path): string
    {
        return self::url($path.'.js');
    }
}
