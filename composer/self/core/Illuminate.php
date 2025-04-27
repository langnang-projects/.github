<?php

namespace Core;

/**
 * 
 * @var string name
 * @var string alias
 * @var object app
 * 
 * @method __construct()
 * @method __call()
 * 
 * @method _autoload()
 * @method _run()
 */
class Illuminate
{
  /**
   * @var string
   */
  public $name;
  /**
   * @var string
   */
  public $alias;
  /**
   * The application instance.
   *
   * @var \Illuminate\Application\Application
   */
  protected $app;
  /**
   * 
   */
  // public $error_code;
  /**
   * 
   */
  // public $error_message;

  // function __set($name, $value = null)
  // {
  //   $this->{$name} = $value;
  // }

  // function __get($name)
  // {
  //   return $this->{$name};
  // }
  // private $aliases;

  // private function setName() {}
  // private function getName() {}
  // private function setAlias() {}
  // private function getAlias() {}

  // protected function _autoload() {}
  // protected function _run() {}
  // protected function _log() {}

  // function __construct() {}
  // function __set($name, $value) {}
  // function __get($name) {}

  // function _log() {}
  // function _debug() {}
  // function _autoload() {}
  // function _print() {}

  /**
   * Resolve the given type from the container.
   * 从容器中解析给定的类型
   */
  // public function make() {}
  // protected function resolve() {}
  /**
   * 
   */
  // public function handle() {}
  /**
   * 
   */
  // public function singleton() {}
  // public function boot() {}
  /**
   * Throw an HttpException with the given data.
   */
  // public function abort($code, $message = '', array $headers = []) {}
  /**
   * 
   */
  // public function register() {}
  public function __construct($app = null)
  {
    $this->app = $app;
  }


  /**
   * Flush the container of all bindings and resolved instances.
   *
   * @return void
   */
  public function flush()
  {
    // parent::flush();
  }
}
