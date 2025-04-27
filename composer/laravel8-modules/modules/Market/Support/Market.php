<?php

namespace Modules\Market\Support;

use Illuminate\Support\Facades\Http;

class Market
{
    public static function start()
    {
    }
    public static function download()
    {
    }

    public static function download_slice()
    {
    }

    public static function getRemoteProjects($url)
    {
        $return = Http::get($url)->json();
        return $return;
    }

    public static function installExample()
    {
    }

    public static function installTheme()
    {
    }

    public static function installModule()
    {
    }

    public static function installPackage($name, $version, $relativePath = null, $files = [])
    {
        var_dump(__METHOD__);
        var_dump([$name, $version, $relativePath, $files]);
        // app('files')->copy();
    }

    public static function installExtension()
    {
    }

    public static function getFileTree($files = [])
    {

    }
}
