<?

use phpspider\core\log;
use phpspider\core\db;

$export = $spider->get_config('export');
$tbname = $export['table'];
if ($export['type'] !== 'db') return;

$db_config = $spider->get_config('db_config');
// 数据库配置
db::set_connect('default', $db_config);
// 数据库链接
db::_init();
$fields = $spider->get_config("fields");
// 数据库结构与规则一致
if (empty(db::get_all("SHOW TABLES LIKE '{$export['table']}'"))) {
  $sql = "CREATE TABLE `{$export['table']}`  (";
  foreach ($fields as $field) {
    if (!isset($field["name"]) || $field["name"] == "") {
      continue;
    }
    $sql .= "\n\t`{$field['name']}` longtext NULL COMMENT '{$field['description']}',";
  }
  $sql = substr($sql, 0, -1) . "\n)ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;";
  // "";
  $result = db::query($sql);
} else {
  // 查询表中所有
  $columns = db::get_all("DESC `{$export['table']}`");
  // print_r($columns);
  $column_keys = array_map(function ($item) {
    return $item['Field'];
  }, $columns);
  // print_r($column_keys);
  $field_keys = array_map(function ($item) {
    return $item['name'];
  }, $fields);
  // print_r($field_keys);
  $insert_colmuns = [];
  $update_columns = [];
  foreach ($field_keys as $field_index => $field_key) {
    $sql = "";
    $index = array_search($field_key, $column_keys);
    if ($index === false) {
      array_push($insert_colmuns, $field_key);
      $sql .= "ALTER TABLE `{$export['table']}` ADD `{$field_key}` longtext NULL COMMENT '{$fields[$field_index]['description']}';\n";
    } else if ($columns[$index]['Type'] !== 'longtext') {
      $sql .= "ALTER TABLE `{$export['table']}` CHANGE `{$field_key}` `{$field_key}` longtext NULL COMMENT '{$fields[$field_index]['description']}';\n";
    }
    if ($sql !== "") {
      db::query($sql);
    }
  }
}
/** mode 数据库操作模式
 * create 创建模式 默认删除后新建数据库
 * update 更新模式 更新数据库结构
 * insert 只增模式
 * replace 替换模式
 * default 默认(只增+部分更新) 根据字段 __flag__ : update 操作数据
 */
if ($mode === 'create') {

  $export = $spider->get_config('export');

  if ($export['type'] !== 'db') return;
  // if ($spider->get_config$config['export']['type'] !== 'db') return;

  // $db_config = $spider->get_config('db_config');
  // // 数据库配置
  // db::set_connect('default', $db_config);
  // // 数据库链接
  // db::_init();
  // $sql = "DROP TABLE IF EXISTS `{$export['table']}` ;\n";
  // $result = db::query($sql);
  // // print_r($sql);
  // // var_dump($result);
  // $sql = "CREATE TABLE `{$export['table']}`  (\n\t`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY";
  // foreach ($spider->get_config("fields") as $field) {
  //   if (!isset($field["name"]) || $field["name"] == "") {
  //     continue;
  //   }
  //   $sql .= ",\n\t`{$field['name']}` longtext NULL COMMENT '{$field['description']}'";
  // }
  // $sql .= "\n)ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;";
  // "";
  // 清空表数据
  db::query("TRUNCATE TABLE {$tbname}");
} elseif ($mode === 'update') {
  if ($spider->get_config('max_fields') != 0) {
    log::error("[mode = update]: max_fields must be 0, else will delete other data;");
    exit();
  }
  /** 更新默认
   * 在数据不存在条件下，跳过该条URL
   */
  $spider->on_fetch_content_url = function ($url, $phpspider) use ($tbname) {
    // 根据URL查询数据库是否存在记录
    $row = db::get_one("SELECT `__url__`,`__current_tiemstamp__`,`__flag__` FROM {$tbname} WHERE `__url__` = '{$url}'");
    if (empty($row)) {
      // 不存在记录
      return false;
    } else {
      // 存在记录：删除=>更新
      db::delete($tbname, "`__url__` = '{$url}'");
    }
  };
} elseif ($mode === 'insert') {
  /** 只增默认
   * 在数据存在条件下，跳过该条URL
   */
  $spider->on_fetch_content_url = function ($url, $phpspider) use ($tbname) {
    // 根据URL查询数据库是否存在记录
    $row = db::get_one("SELECT `__url__`,`__current_tiemstamp__`,`__flag__` FROM {$tbname} WHERE `__url__` = '{$url}'");
    if (!empty($row)) {
      // 存在记录
      return false;
    }
  };
} else {
  /** default 默认(只增+部分更新) 根据字段 __flag__ : update 操作数据
   * 只有在数据存在且__flag__=='update'的条件下，跳过该条URL
   */
  $spider->on_fetch_content_url = function ($url, $phpspider) use ($tbname) {
    // return false
    // 根据URL查询数据库是否存在记录
    $row = db::get_one("SELECT `__url__`,`__current_tiemstamp__`,`__flag__` FROM {$tbname} WHERE `__url__` = '{$url}'");
    if (!empty($row)) {
      // 存在记录
      // log::warn("on_fetch_content_url[url exist]: {$url}");
      // 判断是否需要更新数据
      if ($row['__flag__'] === 'update') {
        // 需要更新，删除原数据
        db::delete($tbname, "`__url__` = '{$url}'");
      } else {
        return false;
      }
    }
  };
}
// exit();
