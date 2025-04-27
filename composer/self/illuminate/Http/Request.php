<?php

namespace Illuminate\Http;

class Request extends \Core\Illuminate
{
  public $_request = [];
  public $_query = [];
  public $_input = [];
  /**
   * 
   */
  function __construct()
  {
    $this->_query = $_GET;
    $this->_input = array_merge([], $_GET, json_decode(file_get_contents("php://input",), true) ?? []);
  }

  /**
   * 检索输入值
   */
  function input($name, $default = null)
  {
    if (array_key_exists($name, $this->_input)) {
      return $this->_input[$name] ?? $default;
    }
    return $default;
  }
  /**
   * 
   */
  function all()
  {
    return $this->_input;
  }
}
