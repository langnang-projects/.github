<?php

namespace App\Http\Controllers;

class ModuleController extends Controller
{
    protected $module;
    protected $moduleName;
    protected $moduleAlias;
    protected $moduleConfig;
    protected $moduleOption;
    public function __construct()
    {
        if (empty($this->moduleName)) {
            dump(get_class($this));
            dump(get_called_class());
            dump(static::class);
        }
        $this->module = $module = \Module::find($this->moduleName);
        if (empty($module))
            return;
        $this->moduleAlias = $moduleAlias = $module->getAlias();
        $this->moduleConfig = config($moduleAlias);
        // $this->moduleOption = \App\Models\Option::find();
        // dump($module->getAlias());
        // dump($this->module);
        // dump($this->moduleName);
        // dump($this->moduleAlias);
        // dump($this->moduleConfig);
        // dump($this->moduleOption);
        // dump(__CLASS__);
    }
    public function view($view = null, $data = [], $mergeData = [])
    {
        // $module = \Module::find($this->moduleName);
        $return = array_merge([
            '$options' => [],
            '$servers' => [],
            '$constants' => [],
            '$variables' => [
                'route' => [
                    'method' => request()->method(),
                    'url' => request()->url(),
                    'fullUrl' => request()->fullUrl(),
                    'path' => request()->path(),
                    'pathInfo' => request()->getPathInfo(),
                ],
                'request' => request()->all(),
            ],
            '$route' => [
                'method' => request()->method(),
                'url' => request()->url(),
                'fullUrl' => request()->fullUrl(),
                'path' => request()->path(),
                'pathInfo' => request()->getPathInfo(),
            ],
            '$request' => request()->all(),
            // 'layout' => "layouts.master",
        ], is_array($view) ? $view : ['view' => $view], $data);
        if (env('WEB_CONSOLE')) {
            echo "<script>window.\$app=" . json_encode($return, JSON_UNESCAPED_UNICODE) . ";</script>";
            echo "<script>console.log('window.\$app',window.\$app);</script>";
        }
        dump($return);
        return view($this->moduleAlias . '::' . \Arr::get($this->moduleConfig, 'framework') . '.' . $return['view'], $return, $mergeData);
    }
}
