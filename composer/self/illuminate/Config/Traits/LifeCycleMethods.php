<?php

namespace Illuminate\Config\Traits;

trait LifeCycleMethods
{
  function _() {}

  function _autoload(...$arguments)
  {
    if (empty(\config('config'))) {
      $config = require_once __DIR__ . '/../Config/config.php';
      $config['name'] = "Config";
      $config['alias'] = "config";
      $this->aliases['config'] = $config;
    }
    foreach (\config('config.paths.configs') as $path) {
      // var_dump($path);
      foreach (\glob($path . '/*/Config/config.php') as $file) {
        $filename = basename(dirname(dirname($file)));

        if (in_array($filename, $_ENV['ILLUMINATE_IGNORES'] ?? [])) continue;
        // var_dump($file);
        // var_dump($filename);
        $config = require_once $file;
        // var_dump($config);
        if ($config === true) continue;

        $alias = $config['alias'] ?? \Str::snake($filename, '-');
        // var_dump($alias);
        $config['name'] = $filename;
        $config['alias'] = $alias;

        $this->aliases[$alias] = $config;
      }
    }
  }




  function _run()
  {
    // $this->router->run();
  }
}
