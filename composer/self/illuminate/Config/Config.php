<?php

namespace Illuminate\Config;

/**
 * 配置项
 * 
 * @method __constuctor
 * @method __get
 * @method __set
 * 
 * @method _init
 * @method _autoload
 * @method _run
 * 
 * @method has()
 * @method void all()
 * @method void get()
 * @method set()
 * @method prepend()
 * @method push()
 * 
 */

class Config extends \Core\Illuminate implements Contracts\ConfigContract
{

  use \Core\Traits\AliasesTrait;

  use Traits\LifeCycleMethods;
  public function has($key) {}
  public function all()
  {
    return $this->aliases;
  }
  public function prepend($key, $value) {}
  public function push($key, $value) {}
  /**
   * 
   */
  public function get($key, $default = null)
  {
    // var_dump(__METHOD__, $key);

    $keys = explode('.', $key);
    // var_dump($keys);
    // 特殊字符 `this` 转换
    if ($keys[0] === 'this') {
      // var_dump(debug_backtrace());

      foreach (debug_backtrace() as $trace) {
        if (in_array($trace['function'], ['config'])) break;
      }
      $file = $trace['file'];
      // var_dump($file);
      foreach (config('config.paths.configs') as $path) {
        $path = realpath($path);
        if (\Str::startsWith($file, $path)) break;
      }
      // var_dump($path);
      foreach (\glob($path . DIRECTORY_SEPARATOR . "*", GLOB_ONLYDIR) as $path) {
        if (\Str::startsWith($file, $path)) break;
      }
      // var_dump($path);
      $filename = basename($path);
      // var_dump($filename);
      foreach ($this->aliases as $alias => $config) {
        // var_dump([$alias, $config]);
        // if(!isset($config['name']) $config['name']=$;
        if ($config['name'] == $filename) break;
      }
      // var_dump($alias, $config);
    } else {
      $config = $this->aliases[$keys[0]] ?? null;
    }
    return array_reduce(array_slice($keys, 1), function ($return, $k) {
      if (empty($return)) return;
      if (!(array_key_exists($k, $return))) return;
      return $return[$k];
    }, $config) ?? $default;
  }
  /**
   * 
   */
  public function set($key, $value = null)
  {
    if (empty($key)) return;

    $keys = explode('.', $key);

    if (sizeof($keys) == 1) {
      $this->aliases[$key] = $value;
    } else {
      $array = &$this->aliases[$keys[0]];
      $keys = array_slice($keys, 1);
      foreach ($keys as $i => $key) {
        if (count($keys) === 1) {
          break;
        }
        unset($keys[$i]);

        if (!isset($array[$key]) || ! is_array($array[$key])) {
          $array[$key] = [];
        }

        $array = &$array[$key];
      }

      $array[array_shift($keys)] = $value;
    }
    return $this;
  }
}
