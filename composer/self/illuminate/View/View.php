<?php

namespace Illuminate\View;

/**
 * @method __constructor
 * 
 * @method render
 * @method make
 */
class View extends \Core\Illuminate
{
  function render($template)
  {
    echo $template;
  }

  function make($view, $data = [], $mergeData = [])
  {
    $alias = $this->alias;

    // var_dump(config('view.paths'));
    // Module View
    if (strpos($view, '::')) {
      // var_dump($view);
      $keys = explode("::", $view);
      $alias = $keys[0];
      $view = $keys[1];
      // dump(config('view.paths'));
      $path = config('view.paths.aliases.' . $alias, '');
      // $dir = implode("-", array_filter([\config($module . '.template'), \config($module . '.theme'), \config($module . '.layout')], function ($v) {
      //   return !empty($v);
      // }));
      // if (!empty($dir)) $dir .= '/';

      // foreach ((array)config('modules.paths.modules') as $path) {
      //   var_dump($path);
      //   foreach (\glob($path . '/*', GLOB_ONLYDIR) as $modulePath) {
      //     var_dump($modulePath);
      //     $filename = pathinfo($modulePath)['filename'];
      //     if ($filename == config($module . '.name')) {
      //       // require_once $module . '/Http/Controllers/' . pathinfo($func[0])['filename'] . '.php';
      //       $file = $modulePath . '/Views/' . $dir . $view . '.php';
      //     }
      //   }
      // }
    } else {
      $path = config('view.paths.views');
      // $dir = implode("-", array_filter([\config('view.template'), \config('view.theme'), \config('view.layout')], function ($v) {
      //   return !empty($v);
      // }));
      // if (!empty($dir)) $dir .= '/';
      // $file = __DIR__ . '/../../views/' . $dir . $view . '.php';
    }
    // dump($path);
    $path .= DIRECTORY_SEPARATOR . implode("-", array_filter([\config($alias . '.template'), \config($alias . '.theme'), \config($alias . '.layout')], function ($v) {
      return !empty($v);
    }));
    // dump($path);
    if (!\Str::endsWith($path, DIRECTORY_SEPARATOR)) $path .= DIRECTORY_SEPARATOR;
    // var_dump($path);
    $file = $path . implode(DIRECTORY_SEPARATOR, explode('.', $view)) . '.php';
    if (!file_exists($file)) throw new \Error(sprintf("file %s not exists", $file));

    $data = array_merge($data, $mergeData);

    foreach ($data as $key => $value) {
      $$key = $value;
    }
    unset($alias, $data, $keys, $view, $path, $mergeData, $value);
    // var_dump($file);
    $rusage = getrusage(0);
    require_once $file;
  }
}
