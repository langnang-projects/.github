<?php

namespace App\Support;

use Illuminate\Support\Traits\Macroable;

// 自动装载
class Autoload
{
    use Macroable;
    // 获取 laravel 文件夹目录下文件及对应类名
    public function getAppClasses($structure)
    {
    }
    public function getClassMap()
    {
    }
    public function getFiles()
    {
    }
    public function getNamespaces()
    {
    }
    public static function getPsr4()
    {
    }
    public static function getReal()
    {
    }
    public static function getStatic()
    {
    }
    // 获取 laravel-modules 文件夹目录下文件及对应类名
    public static function getModuleClasses($structure)
    {
        // var_dump($structure);
        // var_dump(Module::currentConfig('name'));
        // var_dump(config('modules.paths.generator.' . $structure . '.path'));
        // Module::current();
        $return = app('files')->allFiles('modules' . DIRECTORY_SEPARATOR . Module::currentConfig('name') . DIRECTORY_SEPARATOR . config('modules.paths.generator.' . $structure . '.path'));
        // var_dump($return);
        $return = array_map(function ($file) use ($structure) {
            return "\Modules\\"
                . Module::currentConfig('name')
                . "\\"
                . config('modules.paths.generator.' . $structure . '.path')
                . '\\'
                . preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getRelativePathname());
        }, $return);
        // var_dump($return);
        return $return;
    }

    public static function modules()
    {

    }
}