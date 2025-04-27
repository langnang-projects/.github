<?php

namespace Illuminate\Database;

/**
 * Summary of QueryBuilder
 * 
 * @var string $table
 * 
 * @method void __construct
 * @method void table
 */
class QueryBuilder
{
  public $table;

  public function __construct() {}
  function connection() {}
  function table($tbname)
  {
    $this->table = $tbname;
    return $this;
  }
  function select() {}
  function get() {}
  function first() {}
  function exists() {}
}
