<?php

namespace Illuminate\Router;

use Closure;

/**
 * 路由
 * 
 * @method _init
 * @method _autoload
 * @method _run
 * 
 * @method make
 * @method handle
 * @method helper
 * @method addRoute
 * 
 */
class Router extends \Core\Illuminate
{
  public $prefix;
  protected $middlewares = [];
  protected $patterns = [];

  private $routes = [];
  /**
   * Summary of _init
   * @return void
   */
  function _init() {}
  /**
   * Summary of _autoload
   * @return void
   */
  function _autoload()
  {
    foreach (config('router.paths.routes') as $path) {
      // var_dump($path);
      foreach (\glob($path . DIRECTORY_SEPARATOR . '*.php') as $file) {
        require_once $file;
      }
    }
    // dump($this);
  }
  /**
   * Summary of _run
   * @throws \Error
   * @return mixed
   */
  function _run()
  {
    // $_route = new Route(['uri' => $_SERVER['REQUEST_URI'] ?? "/"])->uri;
    file_put_contents(storage_path("framework" . DIRECTORY_SEPARATOR . "routes.json"), json_encode($this->routes));
    // dump($this->routes);
    // $_uri = $this->adjust_uri($_SERVER['REQUEST_URI'] ?? "/");
    // 转换标准地址
    $_uri = new Route(['uri' => $_SERVER['REQUEST_URI'] ?? "/"]);
    // $_route = new Route(['uri' => $_SERVER['REQUEST_URI'] ?? "/"])->uri;
    $uri = strtolower($_uri->uri);

    // dump($_SERVER);
    // dump($uri);
    $method = $_SERVER['REQUEST_METHOD'];

    // dump([$uri, $method, preg_match("/{(.+)}/", $uri, $match)]);
    // dump($this->routes);
    // dump([$uri, preg_match('/^\/manual\/(\\w+)$/', $uri)]);
    // $func = '';
    if (isset($this->routes[$uri]) && isset($this->routes[$uri][$method])) {
      // $func = $route[$method]['function'];
      $route = $this->routes[$uri][$method];
      // dump($route);
    }
    if (empty($route)) {
      // var_dump($this->routes);
      foreach ($this->routes as $route) {
        // 匹配请求方法
        if (!array_key_exists($method, $route)) continue;
        // 模糊匹配
        // dump($route);
        if (!empty($route['pattern'])) {
          // dump($route);
          // dump('/^' . htmlspecialchars($route['pattern']) . '$/');
          // dump($pattern = $route['pattern']);
          $pattern = '/^' . str_replace('/', '\/', $route['pattern']) . '$/';
          if (preg_match($pattern, $uri, $params)) {
            $route = $route[$method];
            $route['args'] = array_slice($params, 1,);
            // dump($route);
            break;
          }
          // dump($pattern = preg_quote($pattern));
          // dump($pattern = str_replace('/', '\/', $pattern));
          // dump(preg_match_all('/^' . $pattern . '$/', $uri,));
          // dump(str_replace('/', '\/', preg_quote($route['pattern'])), preg_match_all('/^' . preg_quote($route['pattern']) . '$/', $uri,));
          // dump($route['pattern'], preg_match_all(htmlspecialchars($route['pattern']), $uri,));
          // if (preg_match_all($route['pattern'], $uri, $args)) {
          // dump($args);
          // }
        }
        unset($route);
      }
    }
    // dump($route);
    unset($pattern);
    // 未匹配到路由
    if (empty($route)) {
      if (array_key_exists("/*", $this->routes)) {
        $route = $this->routes["/*"][$method];
      }
    }
    if (empty($route)) {
      $route = [
        'callback' => function () {}
      ];
    }
    $func = $route['callback'];

    if (is_string($func)) $func = explode("@", $func);

    if (is_array($func)) {
      if (sizeof($func) == 0) {
        throw new \Error("Error route $uri callback");
      } else {
        $controller = $func[0];
        if (\Str::startsWith($controller, '\\')) $controller = substr($controller, 1);
        // var_dump(config('controller.paths.aliases'));
        foreach (config('controller.paths.aliases') as $alias => $path) {
          if (\Str::startsWith($controller, $alias)) break;
        }
        // var_dump($alias);
        // var_dump($path);
        $controller = \Str::after($controller, $alias) . '.php';
        // var_dump($controller);
        foreach (\glob($path . DIRECTORY_SEPARATOR . '*.php') as $file) {
          if (\Str::endsWith($file, $controller)) break;
        }
        // var_dump($file);
        require_once $file;
        // $moduleAlias = array_slice(preg_split('/\\\|\//', $func[0]), 2, 1)[0];
        // var_dump($moduleAlias);

        // foreach (config('controller.paths.controllers') as $path) {
        //   var_dump($path);
        //   foreach (\glob($path . DIRECTORY_SEPARATOR . '*.php') as $file) {
        //     var_dump($file);
        //   }
        // }

        // foreach ((array)config('module.paths.modules') as $path) {
        //   // var_dump($path);
        //   foreach (\glob($path . '/*', GLOB_ONLYDIR) as $modulePath) {
        //     var_dump($modulePath);
        //     $filename = pathinfo($modulePath)['filename'];
        //     if ($filename == $moduleAlias) {
        //       // var_dump($path);
        //       // var_dump($module);
        //       // var_dump($filename);
        //       require_once $modulePath . '/Http/Controllers/' . pathinfo($func[0])['filename'] . '.php';
        //     }
        //   }
        // }

        // require_once __DIR__ . '/../../' . strtolower(substr($func[0], 1, 1)) . str_replace("\\", '/', substr($func[0], 2))  . '.php';
        app_log(__METHOD__ . " " . json_encode($route));
        $controller = new $func[0];
        return (new $func[0])->{$func[1]}(app('request'), ...$route['args'] ?? []);
      }
    }

    app_log(__METHOD__ . " " . json_encode($route));
    return $func(app('request'), ...$route['args'] ?? []);
    // var_dump($_SERVER);
    // $method();
    // $method = $_SERVER['REQUEST_METHOD'];
  }

  function make() {}
  function handle($request, Closure $next) {}
  function helper() {}

  /**
   * app('router')->addRoute($method, $uri, $callback);
   */
  function addRoute(Route $route)
  {
    // var_dump($this->routes);
    // var_dump($route);
    if (!isset($this->routes[$route->uri])) $this->routes[$route->uri] = [
      "uri" => $route->uri,
      "pattern" => $route->pattern,
      "query" => $route->query,
      "params" => $route->params,
    ];
    $this->routes[$route->uri][$route->method] = (array)$route;
    // var_dump($this->routes);
  }
  // function match($methods, $uri, $func)
  // {
  //   foreach ($methods as $method) {
  //     $method = strtoupper($method);
  //     if (!in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'])) continue;
  //     $uri = $this->adjust_uri($uri);
  //     if (!isset($this->routes[$uri['uri']])) $this->routes[$uri['uri']] = $uri;
  //     $this->routes[$uri['uri']][$method] = [
  //       "function" => $func
  //     ];
  //   }
  //   return $this;
  // }
  // function any($uri, $func)
  // {
  //   $this->match(['get', 'post', 'put', 'patch', 'delete', 'options'], $uri, $func);
  // }
  // function get($uri, $func)
  // {
  //   return $this->match([__FUNCTION__], $uri, $func);
  // }
  // function post($uri, $func)
  // {
  //   return $this->match([__FUNCTION__], $uri, $func);
  // }
  // function put($uri, $func)
  // {
  //   return $this->match([__FUNCTION__], $uri, $func);
  // }
  // function patch($uri, $func)
  // {
  //   return $this->match([__FUNCTION__], $uri, $func);
  // }
  // // static function __callStatic($name, $arguments)
  // // {
  // //     var_dump(__METHOD__, $name, $arguments);
  // // }

  // function prefix($prefix)
  // {
  //   $prefix = $this->adjust_uri($prefix);
  //   $this->prefix = rtrim($prefix['uri'], '/');
  //   return $this;
  // }
  // function group($callback)
  // {
  //   $closure = Closure::bind($callback, $this);
  //   $closure();
  //   $this->prefix = null;
  // }

  public function getRoutes()
  {
    return $this->routes;
  }
}
