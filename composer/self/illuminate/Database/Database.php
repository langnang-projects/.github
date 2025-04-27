<?php

namespace Illuminate\Database;

class Database extends \Core\Illuminate
{

  private $connection;

	private $db;

  public $drivers = [];

  private $config = [];
  function _autoload()
  {
    // dump(__METHOD__);
    $this->config = $config = config('database.connections.' . config('database.default'));
    // dump($config);
    // $this->db = new DB($config);

    // Load Drivers
    foreach (\glob(__DIR__ . DIRECTORY_SEPARATOR . 'Drivers' . DIRECTORY_SEPARATOR . '*Driver.php') as $file) {
      // dump($file);
      // dump(strtolower(substr(basename($file), 0, -strlen('Driver.php'))));
      // dump(pathinfo($file));

      $alias = strtolower(substr(basename($file), 0, -strlen('Driver.php')));
      // $driver = substr(basename($file), 0, -strlen('Driver.php'));
      $driver = "\Illuminate\Database\Drivers\\" . pathinfo($file)['filename'];
      $driver = new $driver;
      if (isset($driver->alias)) $alias = $driver->alias;
      // dump($driver);
      $this->drivers[$alias] = $driver;

      // $driver=new "\Illuminate";
      // $class = __NAMESPACE__.'\Drivers\\'.;
    }
    unset($alias, $driver);
    // dump($this);
  }

  function _run() {}
  /**
   * 
   */
  function get_drivers($name = null)
  {
    return empty($name) ? $this->drivers : $this->drivers[$name];
  }
  function get_config()
  {
    return $this->config;
  }
  function set_connnection($name) {}
  function get_connection($name = null) {}
}
