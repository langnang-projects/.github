<?

$id = $_GET['id'];
$task = read_task($_GET['id']);
if (is_null($task)) {
  header("Location: /");
}
$task = new PhpSpiderConfigModel($task);
$task_env_fields = array_map(
  function ($field, $name) {
    return array_merge($field, [
      "name" => $name,
      "table_show" => false,
      "env_flag" => true,
    ]);
  },
  parse_ini_file(__DIR__ . "/../.env.fields", true),
  array_keys(parse_ini_file(__DIR__ . "/../.env.fields", true))
);
$task->__construct(array_merge(
  parse_ini_file(__DIR__ . "/../.env", true),
  ["fields" => $task_env_fields]
), true);

$task = $task->to_array();

use phpspider\core\db;

$db_config = $task['db_config'];
// 数据库配置
db::set_connect('default', $db_config);
// 数据库链接
db::_init();

$page = (int)(isset($_GET['page']) ? $_GET['page'] : 1);
$page_size = 10;
$offset = ($page - 1) * $page_size;

$rows = db::get_all("Select * From `{$task['key']}` LIMIT {$page_size} OFFSET {$offset}");
$total = (int)(db::get_one("Select COUNT(*) AS \"count\" From `{$task['key']}`"))['count'];
$page_max = ceil($total / $page_size);

// var_dump($task['fields'])
?>
<style>
  /* td {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  } */

  ul.list-group {
    margin-bottom: 0;
  }
</style>
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th width="80">#</th>
      <? foreach (array_filter($task['fields'], function ($item) {
        return $item['table_show'] === true;
      }) as $field) : ?>
        <th><? echo $field['description'] ?: $field['name'] ?></th>
      <? endforeach ?>
    </tr>
  </thead>
  <tbody>
    <? foreach ($rows ?: [] as $index => $row) :  ?>
      <tr>
        <td><i class="glyphicon glyphicon-triangle-right" style="margin-left:-8px;" onclick="toggleCollapse(this)"></i><? echo $page_size * ($page - 1) + $index + 1 ?></td>
        <? foreach (array_filter($task['fields'], function ($item) {
          return $item['table_show'] === true;
        }) as $field) : ?>
          <td title="<? echo $row[$field['name']] ?>"><? echo $row[$field['name']] ?></td>
        <? endforeach ?>
      </tr>
      <tr class="collapse">
        <td class="panel panel-primary" colspan="999">
          <div class="panel-body">
            <ul class="list-group">
              <? foreach (array_filter($task['fields'], function ($item) {
                return $item['table_show'] !== true;
              }) as $field) : ?>
                <li class="list-group-item"><? echo $field['description'] ?: $field['name'] ?>: <? echo $row[$field['name']] ?></li>
              <? endforeach ?>
            </ul>
          </div>
        </td>
      </tr>
    <? endforeach ?>
  </tbody>
  <tfoot>

  </tfoot>
</table>
<nav aria-label="Page navigation">
  <label for="">共 <? echo $total ?> 条 第<? echo $page ?>页 </label>
  <ul class="pager" style="margin-top: 0;">
    <li class="previous">
      <a href="?id=<? echo $id ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <? for ($i = $page - 5; $i <= ($page + 5); $i++) {
      if ($i > 0 && $i <= $page_max) {
        echo "<li><a href=\"?id={$id}&page={$i}\">{$i}</a></li>";
      }
    }
    ?>
    <li class="next">
      <a href="?id=<? echo $id ?>&page=<? echo $page_max ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>