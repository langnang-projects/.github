<?php

namespace Illuminate\Router;

/**
 * 路由
 * @name Routes
 * 
 * @var $name
 * @var $description
 * @var $method
 * @var $uri
 * @var $pattern
 * @var $query
 * @var $params
 * @var $callback
 * @var $prefix
 * 
 * @method __construct()
 * 
 * @method _init()
 * @method _call()
 * @method _standard()
 * 
 * @method match()
 * @method any()
 * @method get()
 * @method post()
 * @method put()
 * @method patch()
 * @method prefix()
 * @method group()
 * @method handle()
 * @method helper()
 * @method name()
 * 
 */
class Route
{
  public $name;
  public $method;
  public $uri;
  public $pattern;
  public $query;
  public $params;
  public $callback;
  public $prefix;

  /**
   * Magic
   */
  function __construct($arguments = [])
  {
    if (empty($arguments)) return;
    $this->_init($arguments['uri']);
  }
  /**
   * LifeCycle
   */
  /**
   * 以`/`开头，不以`/`结尾
   */
  function _init($uri)
  {
    // dump($this->prefix);
    // 替换全部空格
    $uri = preg_replace('/ /', '', $uri);

    $uri = rtrim($uri, '/');
    // if (Str::endsWith($uri, '/')) $uri = substr($uri, 0, -1);

    if (!\Str::startsWith($uri, "/")) $uri = '/' . $uri;

    if (!empty($this->prefix)) {
      $uri = $this->prefix .  $uri;
      $uri = rtrim($uri, '/');
    }
    // 去除?及后面内容
    $this->uri = preg_replace('/\?[\w].*$/', '', $uri);

    if (preg_match_all("/{([\w\.-\?]+)}/", $uri, $params)) {
      $this->params = $params[1];
      // dump([$uri, preg_match_all("/{(\w+)}/", $uri, $params)]);
      // dump([$params]);
      $this->pattern = str_replace($params[0], array_fill(0, count($params[0]), "([\w\.-]+)"), $uri);
    }
    // return [
    //   'uri' => $uri,
    //   'pattern' => isset($pattern) ? $pattern : null,
    //   'params' => $params[1],
    //   'query' => []
    // ];
    app_log(__METHOD__ . ": " . $this->uri);
    return $this;
  }
  function _call() {}
  function _standard() {}
  /**
   * Common
   */
  function match($methods, $uri, $callback)
  {
    if (app('router')->prefix) $this->prefix = app('router')->prefix;
    // dump($GLOBALS);
    foreach ($methods as $method) {
      $method = strtoupper($method);
      if (!in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'])) continue;

      $this->_init($uri);
      $this->method = $method;
      $this->callback = $callback;
      app('router')->addRoute($this);
      // if (!isset($this->routes[$uri['uri']])) $this->routes[$uri['uri']] = $uri;

      // $this->routes[$uri['uri']][$method] = [
      //   "function" => $callback
      // ];
    }
    return $this;
  }
  function any($uri, $callback)
  {
    return $this->match(['get', 'post', 'put', 'patch', 'delete', 'options'], $uri, $callback);
  }
  function get($uri, $callback)
  {
    return $this->match([__FUNCTION__], $uri, $callback);
  }
  function post($uri, $callback)
  {
    return $this->match([__FUNCTION__], $uri, $callback);
  }
  function put($uri, $callback)
  {
    return $this->match([__FUNCTION__], $uri, $callback);
  }
  function patch($uri, $callback)
  {
    return $this->match([__FUNCTION__], $uri, $callback);
  }
  // static function __callStatic($name, $arguments)
  // {
  //     var_dump(__METHOD__, $name, $arguments);
  // }

  function prefix($prefix)
  {
    // app()
    // $prefix = $this->adjust_uri($prefix);
    // $this->prefix = rtrim((new Route(['uri' => $prefix]))->uri, '/');
    app('router')->prefix = $this->prefix = rtrim((new Route(['uri' => $prefix]))->uri, '/');
    // var_dump($this->prefix);
    return $this;
  }
  function group($callback)
  {
    $closure = \Closure::bind($callback, $this);
    // $closure = $callback->bindTo($this);
    // dump($this->prefix);
    $closure();
    // $this->prefix = null;
    // var_dump(app('router'));
    app('router')->prefix = $this->prefix = null;
  }
  function handle($request, Closure $next) {}

  function helper() {}

  function name($name)
  {
    $this->name = $name;
    return $this;
  }
  function description($description)
  {
    $this->name = $description;
    return $this;
  }
}
