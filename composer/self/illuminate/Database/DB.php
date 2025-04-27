<?php

namespace Illuminate\Database;

/**
 * @var string $alias
 * @var array $configs
 * @var object $conn
 * 
 * @method void connection
 * @method void query
 * @method void insert
 * @method void delete
 * @method void update
 * @method void select
 * 
 * @manual 
 */

class DB
{
  public $conn;
  public $configs = [];
  public $sql;
  public $result;
  public function __construct()
  {
    $this->configs = config('database.connections');
    // dump($this);
  }
  /**
   * Summary of connection
   * @param mixed $name
   * @return bool|\mysqli
   */
  public function connection($name = null)
  {
    if (empty($name)) $name = config('database.default');
    $config = $this->configs[$name];
    // 创建连接
    $conn = @mysqli_connect(
      $config['host'],
      $config['username'],
      $config['password'],
      $config['database'],
      $config['port'],
    );
    if ($conn->connect_error) {
      throw new \Error("连接失败: " . $conn->connect_error);
    }
    return $this->conn = $conn;
  }
  public function table($tbname) {}

  private function query()
  {
    // dump($this->sql);
    if (empty($this->conn)) $this->connection();
    return $return = @mysqli_query($this->conn, $this->sql);
  }
  public function insert($table, $where = null) {}
  public function delete($table, $where = null)
  {
    // 小心全部被删除了
    if (empty($where)) {
      return false;
    }
  }
  public function update($table, $data = [], $where = null) {}
  public function select($table, $where = null)
  {
    $where = empty($where) ? "WHERE 1 = 1" : "WHERE " . implode(" And ", $where);

    $this->sql = sprintf("SELECT * FROM `{$table}` {$where}");

    $result = $this->query();
    $return = [];
    if (mysqli_num_rows($result) > 0) {
      // 输出数据
      while ($row = mysqli_fetch_assoc($result)) {
        array_push($return, $row);
      }
    }
    return $return;
  }

  public function statement() {}
  public function listen() {}
  public function transaction() {}
  public function beginTransaction() {}
  public function rollBack() {}
  public function commit() {}
  public function getTablePrefix() {}
  public function close()
  {
    mysqli_close($this->conn);
    $this->conn = null;
  }
}
