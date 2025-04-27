<?php

namespace Illuminate\Modular;

class Modular extends \Core\Illuminate
{


  use \Core\Traits\AliasesTrait;

  function get($key = null)
  {
    if (empty($key)) {
      return $this->aliases;
    } else {
      return $this->aliases[$key];
    }
  }
  function _autoload(...$arguments)
  {
    // var_dump(config('modules.paths.modules'));
    // var_dump(resource_path());
    // var_dump(base_path('modules'));

    // var_dump(app('config')->_autoload());
    // var_dump(config('config'));

    // var_dump(__METHOD__);
    $routePaths = [];
    $configPaths = [];
    $controllerPaths = [];
    foreach ((array)config('modular.paths.modules') as $path) {
      // var_dump($path);
      array_push($configPaths, $path);
      foreach (\glob($path . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) as $module) {
        // var_dump($module);
        // config
        $filename = pathinfo($module)['filename'];
        // var_dump($filename);
        $config = require_once $module . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'config.php';
        // var_dump($config);
        // if (isset($config['alias'])) $alias = $config['alias'];
        // else $alias = \Str::snake($filename, '-');
        $alias = $config['alias'] ?? \Str::snake($filename, '-');
        // var_dump($alias);
        $this->aliases[$alias] = [
          'name' => $filename,
          'alias' => $alias,
          'path' => $module,
        ];
        \Config::set($alias, array_merge($config, $this->aliases[$alias]));

        \Config::set('view.paths.aliases.' . $alias, $module . DIRECTORY_SEPARATOR . 'Views');

        \Config::set('controller.paths.aliases.' . 'Modules\\' . $filename, $module . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers');

        array_push($routePaths, $module . DIRECTORY_SEPARATOR . 'Routes');

        // array_push($controllers, $module . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers');

        // $config['name'] = $filename;
        // $config['alias'] = $alias;
        // $config['module_path'];
        // var_dump($config);
        // array_push($this->aliases, $alias);
        // \app('config')->set($alias, $config);

        // routes
        // foreach (\glob($module . '/Routes/*.php') as $route) {
        //   // var_dump($route);
        //   require_once $route;
        // }
      }
    }
    // var_dump(config('route.paths.routes'));
    // var_dump($routes);
    \Config::set('router.paths.routes', array_merge(config('router.paths.routes'), $routePaths));
    \Config::set('config.paths.configs', array_merge(config('config.paths.configs'), $configPaths));
    // var_dump(config('route.paths.routes'));
    // \Config::set('controller.paths.controllers', array_merge(config('controller.paths.controllers'), $controllers));
    // var_dump(config('controller.paths.controllers'));
    // var_dump(config('controller.paths.aliases'));

    app('router')->_autoload();
    // var_dump();
    // \Config::set('config.paths.configs', array_merge((array)config('config.paths.configs'), (array)config('module.paths.modules')));

    // var_dump(config('config.paths.configs'));
    // \Config::_autoload();

    // var_dump(config());

    // var_dump($this->aliases);
  }
  function _print(...$arguments)
  {
    parent::{__FUNCTION__}(...$arguments);

    // aliases
    echo "<table><thead><tr class='h'><th colspan='2'> Aliases (" . sizeof($this->aliases) . ") </th><th> Annotation </th></tr></thead><tbody class='d-none'>";
    // echo '<tr class="h"><th>memcache support</th><th>enabled</th></tr>';
    foreach ($this->aliases as $alias => $module) {
      echo "<tr><td class=\"e\">" . $module['name'] . "</td><td class=\"v\">$alias</td><td class=\"v\"></td></tr>";
    }
    unset($alias, $module);
    echo "</tbody></table>";
  }
}
