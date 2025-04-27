<?php


namespace Langnang\PhpServer;

use FastRoute;


class Router
{
  public $dispatcher;
  public $handler;
  public $method;
  public $uri;
  public $route;

  function  __construct($routes)
  {
    $this->dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) use ($routes) {
      foreach ($routes as $route) {
        $r->addRoute($route['method'], $route['uri'], $route);
      }
    });
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->uri = $_SERVER['REQUEST_URI'];
    // Strip query string (?foo=bar) and decode URI
    if (false !== $pos = strpos($this->uri, '?')) {
      $this->uri = substr($this->uri, 0, $pos);
    }
    $this->uri = rawurldecode($this->uri);

    $this->route = $this->dispatcher->dispatch($this->method, $this->uri);
  }

  function run()
  {
    switch ($this->route[0]) {
      case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        return 404;

        exit;
        break;
      case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $this->route[1];
        // ... 405 Method Not Allowed
        return 405;
        exit;
        break;
      case FastRoute\Dispatcher::FOUND:
        // $handler = $this->route[1];
        // $vars = $this->route[2];
        // var_dump($handler);
        // var_dump($vars);
        // ... call $handler with $vars
        // if (is_object($handler)) {
        //   $result = $handler($vars);
        // } else if (is_string($handler) && function_exists($handler)) {
        //   $result = call_user_func($handler, $vars);
        // } else if (is_array($handler) && method_exists($handler[0], $handler[1])) {
        //   $result = call_user_func($handler, $vars);
        // } else {
        //   if (file_exists($rootPath . $handler)) {
        //     echo $twig->render($handler, $vars);
        //   }
        // }
        break;
    }
  }
}
