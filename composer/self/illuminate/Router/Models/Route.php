<?php

namespace Illuminate\Router\Models;

class Route
{
  public $name;
  public $method;
  public $uri;
  public $pattern;
  public $query;
  public $params;
  public $callback;
  function __construct($params) {}
}
