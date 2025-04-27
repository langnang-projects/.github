<?php

namespace Illuminate\Environment;

class Environment extends \Core\Illuminate
{
  public $alias = 'env';
  private $env = [];
  private $agents = [
    'mobile' => ['Android', 'iPhone', 'iPod', 'iPad', 'Windows Phone', 'BlackBerry', 'SymbianOS', 'Mobile'],
    'pc' => [],
  ];
  function __construct()
  {
    // var_dump($GLOBALS);
    $_SERVER['System'] = php_uname();
    $this->env = $_ENV;
  }

  function get($name = null)
  {
    // var_dump(__METHOD__);
    if (empty($name)) {
      return $this->env;
    } else {
      if (array_key_exists($name, $this->env)) return $this->env[$name];
      else return;
    }
  }

  function is_mobile()
  {
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
      foreach ($this->agents['mobile'] as $agent) {
        if (strpos($_SERVER['HTTP_USER_AGENT'], $agent) !== false) {
          return true;
        }
      }
    }
    return false;
  }
  function is_pc() {}
}
