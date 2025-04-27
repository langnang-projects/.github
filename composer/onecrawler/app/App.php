<?php

namespace Langnang\PhpServer;

use Exception;
use Langnang\OneCrawler\Source;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extra\String\StringExtension;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem;

require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/Source.php';

class App
{
  public $config;
  public $conn;
  public static $routes = [];
  public $router;
  public $loader;
  public $twig;
  public $fs;
  function __construct($config)
  {
    $this->config = $config;
    $this->router = new Router(self::$routes);
    $this->conn = new Connection();
    $this->loader = new FilesystemLoader(__DIR__ . '/../views/');
    $this->twig = new Environment($this->loader, []);
    $this->twig->addExtension(new StringExtension());

    $this->twig->addFunction(new \Twig\TwigFunction('array', function ($var) {
      return (array)$var;
    }));
    foreach (['implode', 'parse_url'] as $func) {
      $this->twig->addFunction(new \Twig\TwigFunction($func, function (...$args) use ($func) {
        return $func(...$args);
      }));
    }

    $this->fs = new Filesystem(new LocalFilesystemAdapter(ROOT_PATH));
  }
  function start()
  {
    $this->router->run();
    $handler = $this->router->route[1];
    $vars = array_merge($_GET, $_POST, (array)json_decode(file_get_contents('php://input'), true), (array)$this->router->route[2]);
    //
    if ($handler['view']) {
      require_once __DIR__ . '/../views/' . $handler['path'];
    }
    // 
    else if ($handler['render']) {
      echo $this->twig->render($handler['path'], $vars);
    }
    // 
    else if (isset($handler['callback'])) {
      $callback = $handler['callback'];
      if (is_object($callback)) {
        $result = $callback($vars, $this);
      } else if (is_string($callback) && function_exists($callback)) {
        $result = call_user_func($callback, $vars, $this);
      } else if (is_array($callback) && method_exists($callback[0], $callback[1])) {
        $result = call_user_func($callback, $vars, $this);
      }
      // 输出结果
      if (!$result) {
        return;
      }
      // 结果不存在或为字符串，返回400
      if (is_string($result)) {
        $result = [
          "status" => 400,
          "statusText" => $result ? $result : "Error",
        ];
      } else if (is_object($result)) {
        $result = array(
          "status" => 200,
          "statusText" => 'Success',
          "data" => $result,
        );
      }
      // 如果存在状态码
      else if (isset($result["status"]) && is_numeric($result["status"])) {
        $status = isset($result["status"]) ? $result["status"] : 400;
        $statusText = isset($result["statusText"]) ? $result["statusText"] : "";
        if ($statusText == '') {
          switch ($status) {
            case 200:
              $statusText = "Success";
              break;
            default:
              $statusText = "Error";
              break;
          }
        }
        $result = array(
          "status" => $status,
          "statusText" => $statusText,
          "data" => $result["data"],
        );
      }
      // 不存在状态码，直接输出200
      else {
        // 存在参数data,取data值
        if (isset($result["data"])) {
          $result = array(
            "status" => 200,
            "statusText" => 'Success',
            "data" => $result["data"],
          );
        } else {
          $result = array(
            "status" => 200,
            "statusText" => 'Success',
            "data" => $result,
          );
        }
      }
      header('Content-Type: application/json');
      echo json_encode(array_filter((array)$result), JSON_UNESCAPED_UNICODE);
    }
  }

  function request()
  {
  }
  static function response($method, $uri, $callback)
  {
    array_push(self::$routes, [
      'method' => $method,
      'uri' => $uri,
      'callback' => $callback,
    ]);
  }
  /**
   * 直接加载视图文件
   */
  static function render_view($uri, $path)
  {
    array_push(self::$routes, [
      'method' => "GET",
      'uri' => $uri,
      'path' => $path,
      'view' => true
    ]);
  }
  /**
   * 使用模板引擎渲染视图
   */
  static function render($uri, $path)
  {
    array_push(self::$routes, [
      'method' => "GET",
      'uri' => $uri,
      'path' => $path,
      'render' => true
    ]);
  }

  function getSource($key = null)
  {
    if (!isset($this->config['sources'])) $this->config['sources'] = [];
    if (!$key) return $this->config['sources'];
    return array_shift(array_filter($this->config['sources'], function ($item) use ($key) {
      return $item['key'] == $key;
    }));
  }
  function insert_source($source)
  {
    try {
      $source = new Source($source);
      $sources = $this->select_source();
      array_unshift($sources, $source);
      $this->fs->write("source.json", json_encode($sources, JSON_UNESCAPED_UNICODE));
    } catch (Exception $e) {
      return 400;
    }
    return 200;
  }
  function delete_source($source, $ids)
  {
    try {
      $source = new Source($source);
      $sources = $this->select_source();
      $sources = array_filter($sources, function ($item) use ($ids) {
        return !in_array($item->id, $ids);
      });
      $this->fs->write("source.json", json_encode(array_values($sources), JSON_UNESCAPED_UNICODE));
    } catch (Exception $e) {
      return 400;
    }
    return 200;
  }
  function update_source($source)
  {
    try {
      // $className = lcfirst(end(explode("\\", get_class($source))));
      // $fileName = "source.json";
      $sources = $this->select_source();

      $sources = array_filter($sources, function ($item) use ($source) {
        return !in_array($item->id, [$source['id']]);
      });

      array_unshift($sources, new Source($source));
      // $sources = array_map(function ($item) use ($source) {
      //   if ($item->id === $source['id']) return new Source($source);
      //   return $item;
      // }, $sources);
      // var_dump($sources);
      // $sources = json_decode(file_get_contents(ROOT_PATH . "/source.json"), true);
      // $sources = array_map(function ($item) use ($source) {
      //   if ($item->id === $source->id) return $source;
      //   return $item;
      // }, $sources);
      $this->fs->write("source.json", json_encode(array_values($sources), JSON_UNESCAPED_UNICODE));
    } catch (Exception $e) {
      return 400;
    }
    return 200;
  }
  function select_source($class = null, $id = null)
  {
    try {
      if (!file_exists(ROOT_PATH . "/source.json")) {
        return [];
      }
      $sources = json_decode(file_get_contents(ROOT_PATH . "/source.json"), true);
      $sources = array_map(function ($item) {
        return new Source($item);
      }, $sources);
      if (!is_null($class)) {
        $sources = array_values(array_filter($sources, function ($item) use ($class) {
          return $item->class == $class;
        }));
      }
      if (is_null($id)) {
        return $sources;
      } else {
        return array_shift(array_filter($sources, function ($item) use ($id) {
          return $item->id == $id;
        }));
      }
    } catch (Exception $e) {
      return 400;
    }
    return 200;
  }
}
