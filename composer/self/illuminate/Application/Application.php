<?php

namespace Illuminate\Application;

/**
 * 
 * @var name
 * @var alias
 * @var facades
 * @var plugins
 * 
 * @method __construct
 * @method __call
 * 
 * @method _init
 * @method _autoload
 * @method _log
 * 
 * @method get
 * @method make
 * @method register
 * @method sigleton
 * @method get		
 * @method make		
 * @method register		
 * @method singleton		
 * @method singletonIf		
 * @method flush		
 * @method set_aliases		
 * @method get_aliases		
 * @method alias_exists		
 * @method path		
 * @method setBasePath		
 * @method resourcePath		
 * @method basePath		
 * @method databasePath		
 * @method publicPath		
 * @method langPath		
 * @method configPath		
 * @method storagePath		
 * @method logPath		
 * @method set_facades		
 * @method get_facades		
 * @method facade_exists
 */
class Application extends \Core\Illuminate
{
  /**
   * @var string
   */
  public $name = 'Application';
  /**
   * @var string
   */
  public $alias = "app";
  /**
   * @var array
   */
  private $facades = [];
  /**
   * @var array
   */
  private $plugins = [];

  // public $logs = [];
  use \Core\Traits\AliasesTrait;
  use Traits\AbsolutePath;
  use Traits\FacadesTrait;
  // use Traits\LifeCycleMethods;
  // use Traits\MagicMethods;

  public function __construct($basePath = null)
  {
    // var_dump(__FILE__);
    // var_dump(__CLASS__);
    if ($basePath) {
      $this->setBasePath($basePath);
    }
    $_SERVER['USER_UNIQUE'] = substr(md5(serialize([
      "USERDOMAIN" => $_SERVER["USERDOMAIN"] ?? '',
      "USERDOMAIN_ROAMINGPROFILE" => $_SERVER["USERDOMAIN_ROAMINGPROFILE"] ?? '',
      "USERNAME" => $_SERVER["USERNAME"] ?? '',
      "USERPROFILE" => $_SERVER["USERPROFILE"] ?? '',
      "HTTP_USER_AGENT" => $_SERVER["HTTP_USER_AGENT"] ?? '',
      "HTTP_SEC_CH_UA_PLATFORM" => $_SERVER['HTTP_SEC_CH_UA_PLATFORM'] ?? '',
    ])), 8, 16);
    // var_dump($_SERVER);
    // var_dump(debug_backtrace());
    $this->logPath = $this->logPath("app." . date('Ymd') . '.' . $_SERVER['USER_UNIQUE'] . ".log");

    // $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // if (file_exists($this->logPath)) unlink($this->logPath);

    // $this->_log($url . "\n");

    // load core modules
    foreach (\glob(dirname(__DIR__) . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) as $file) {

      $filename = pathinfo($file)['filename'];

      // if (in_array($filename, $_ENV['ILLUMINATE_IGNORES'] ?? [])) continue;

      // var_dump($this->basePath("storage" . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR . "startup.log"));
      // var_dump($filename);
      $className = "Illuminate\\$filename\\$filename";

      foreach (\glob($file . DIRECTORY_SEPARATOR . 'Facades' . DIRECTORY_SEPARATOR . '*.php') as $facade) {
        $facadeName = pathinfo($facade)['filename'];
        // \class_alias("Illuminate\\$filename\Facades\\$facadeName", $facadeName);
        $facadeClass = "Illuminate\\$filename\Facades\\$facadeName";
        $this->register($facadeClass);
        // $this->facades[$facadeName] = "Illuminate\\$filename\Facades\\$facadeName";
        // $this->_log(__METHOD__ . " Facade \"$facadeName\" ");
      }

      if ($className == __CLASS__) continue;

      $this->register($className);


      // array_push($this->_aliases, $alias);

      // $this->{$alias} = $class;
      // var_dump($class);
    }
    $this->_log(null);
    // var_dump($this->_aliases);
    // load helpers
    // foreach ($cfg['supports'] as $support) {
    // require_once $support;
    // }
  }

  public function __call($name, $arguments)
  {
    if (method_exists($this, $name)) {
      return $this->{$name}(...$arguments);
    }
    if (isset($this->aliases[$name])) {
      $illuminate = $this->aliases[$name];
      if (method_exists($illuminate, 'get')) {
        return $illuminate->{'get'}(...$arguments);
      }
    }
  }
  protected function _log($text, $path = null)
  {
    $path = $path ?? $this->logPath;

    $handle = fopen($path, 'a');
    $text = empty($text) ? "\n" : "[" . date('Y-m-d h:i:s') . "] " . $text . "\n";

    fwrite($handle, $text);
    fclose($handle);
  }
  protected function _autoload(...$arguments)
  {
    foreach ($this->aliases as $alias => $illuminate) {
      if (method_exists($illuminate, __FUNCTION__)) {
        $this->_log(__METHOD__ . " \"$alias\"");
        $illuminate->{__FUNCTION__}(...$arguments);
      }
    }
    // dump(config('app.aliases'));
    // foreach (config('app.aliases') ?? [] as $alias => $path) {
    //   $this->aliases[$alias] = $path;
    // }
    $this->_log(null);
  }
  protected function _run(...$arguments)
  {
    foreach ($this->aliases as $alias => $illuminate) {
      if (method_exists($illuminate, __FUNCTION__)) {
        $this->_log(__METHOD__ . " \"$alias\"");
        $illuminate->{__FUNCTION__}(...$arguments);
      }
    }
    $this->_log(null);
  }

  function get($name = null)
  {
    if (empty($name)) return $this;
    return $this->aliases[$name];
  }
  /**
   * Resolve the given type from the container.
   * 从容器中解析给定的类型
   */
  public function make($abstract, $value = null)
  {

    if (class_exists($abstract)) {
      if ($abstract instanceof \Core\Illuminate) {
      } else if ($abstract instanceof \Core\Facade) {
      }
      // print_r($aliasOrClass);
      $class = new $abstract;
      $filename = pathinfo($abstract)['filename'];
      // var_dump($class);

      if (isset($class->alias)) $alias = $class->alias;
      else $alias = strtolower(preg_replace('/([a-z])([A-Z])/', '${1}-${2}', $filename));

      $class->name = $filename;
      $class->alias = $alias;

      $this->aliases[$alias] = $class;
      return $class;
    } else {
      $this->aliases[$abstract] = $value;
    }
  }
  /**
   * 
   */
  public function register($abstract)
  {
    if (!class_exists($abstract)) return;
    if (new $abstract instanceof \Core\Illuminate) {
      $this->registerAlias($abstract);
    }
    if (new $abstract instanceof \Core\Facade) {
      $this->registerFacade($abstract);
    }
  }
  /**
   * 
   */
  protected function registerAlias($abstract)
  {
    $class = new $abstract($this);
    // $filename = pathinfo($abstract)['filename'] ?: null;
    $abstractExploded = explode("\\", $abstract);
    $filename = end($abstractExploded);
    if (empty($filename)) return;
    // var_dump($class);

    if (isset($class->alias)) $alias = $class->alias;
    else $alias = strtolower(preg_replace('/([a-z])([A-Z])/', '${1}-${2}', $filename));

    $class->name = $filename;
    $class->alias = $alias;

    $this->aliases[$alias] = $class;
    $this->_log(__METHOD__ . " \"$alias\" => \"$abstract\"");
  }
  /**
   * 
   */
  protected function registerFacade($abstract)
  {
    // $filename = pathinfo($abstract)['filename'] ?: null;
    // var_dump($abstract);
    // var_dump(explode("\\", $abstract));
    $abstractExploded = explode("\\", $abstract);
    $filename = end($abstractExploded);
    if (empty($filename)) return;
    $this->facades[$filename] = $abstract;
    \class_alias($abstract, $filename);
    $this->_log(__METHOD__ . " \"$abstract\" ");
  }
  /**
   * Register a shared binding in the container.
   *
   * @param  string  $abstract
   * @param  \Closure|string|null  $concrete
   * @return void
   */
  public function singleton($abstract, $concrete = null) {}
  /**
   * Register a shared binding if it hasn't already been registered.
   *
   * @param  string  $abstract
   * @param  \Closure|string|null  $concrete
   * @return void
   */
  public function singletonIf($abstract, $concrete = null) {}
}
