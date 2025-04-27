<?

use phpspider\core\db;
use Langnang\PhpSpiderConfigModel;

$rows = db::get_all("SELECT * FROM `$tbname`");
$tabs = [];
foreach ($rows as $row) {
  $keys = explode('_', $row["key"]);
  if (!isset($tabs[$keys[0]])) $tabs[$keys[0]] = [];
  $source = ($row['source'] == '' ? 'default' : $row['source']);
  if (!isset($tabs[$keys[0]][$source])) $tabs[$keys[0]][$source] = [];
  array_push($tabs[$keys[0]][$source], $row);
}
?>
<style>
  summary::before {
    content: "\e250";
  }

  details[open] summary::before {
    content: "\e252";
  }
</style>
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th width="60" style="">#</th>
      <!-- <th width="240">Key</th> -->
      <th>Name</th>
      <th>Source</th>
      <th>Key</th>
      <th>Rows</th>
      <th width="90">Status</th>
      <th width="160">
        <div class="btn-group btn-group-xs pull-right" role="group">
          <a href="/insert?env=<? echo substr($env, 1) ?>" type="button" class="btn btn-default glyphicon glyphicon-plus"></a>
          <a href="/download?env=<? echo substr($env, 1) ?>" class="btn btn-default glyphicon">
            <svg xmlns=" http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12">
              <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
              <path d="M480 352h-133.5l-45.25 45.25C289.2 409.3 273.1 416 256 416s-33.16-6.656-45.25-18.75L165.5 352H32c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h448c17.67 0 32-14.33 32-32v-96C512 366.3 497.7 352 480 352zM432 456c-13.2 0-24-10.8-24-24c0-13.2 10.8-24 24-24s24 10.8 24 24C456 445.2 445.2 456 432 456zM233.4 374.6C239.6 380.9 247.8 384 256 384s16.38-3.125 22.62-9.375l128-128c12.49-12.5 12.49-32.75 0-45.25c-12.5-12.5-32.76-12.5-45.25 0L288 274.8V32c0-17.67-14.33-32-32-32C238.3 0 224 14.33 224 32v242.8L150.6 201.4c-12.49-12.5-32.75-12.5-45.25 0c-12.49 12.5-12.49 32.75 0 45.25L233.4 374.6z" />
            </svg>
          </a>
          <button type="button" class="btn btn-default glyphicon" data-toggle="modal" data-target="#modalForUpload">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12">
              <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
              <path d="M105.4 182.6c12.5 12.49 32.76 12.5 45.25 .001L224 109.3V352c0 17.67 14.33 32 32 32c17.67 0 32-14.33 32-32V109.3l73.38 73.38c12.49 12.49 32.75 12.49 45.25-.001c12.49-12.49 12.49-32.75 0-45.25l-128-128C272.4 3.125 264.2 0 256 0S239.6 3.125 233.4 9.375L105.4 137.4C92.88 149.9 92.88 170.1 105.4 182.6zM480 352h-160c0 35.35-28.65 64-64 64s-64-28.65-64-64H32c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h448c17.67 0 32-14.33 32-32v-96C512 366.3 497.7 352 480 352zM432 456c-13.2 0-24-10.8-24-24c0-13.2 10.8-24 24-24s24 10.8 24 24C456 445.2 445.2 456 432 456z" />
            </svg>
          </button>
        </div>
      </th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($rows ?: [] as $index => $task) :
      $task = new PhpSpiderConfigModel($task);

    ?>
      <tr>
        <th scope="row"><i class="glyphicon glyphicon-triangle-right" style="margin-left:-8px;" onclick="toggleCollapse(this)"></i><? echo $index + 1; ?> </th>
        <!-- <td alt=""><? echo $task->key ?></td> -->
        <td alt="名称">
          <? echo $task->name ?>
          <? if ($task->template) : ?>
            <span class="badge badge-primary">模板</span>
          <? endif ?>
        </td>
        <td> <? echo $task->source ?> </td>
        <td> <? echo $task->key ?> </td>
        <td><? echo $task->fields_num ?: 0 ?> / <? echo $task->collected_urls_num ?: 0 ?> / <? echo $task->collect_urls_num ?: 0 ?></td>
        <td alt="状态"><? echo $task->status ?></td>
        <td alt="">
          <div class="btn-group btn-group-xs pull-right" role="group">
            <!-- <button class="btn btn-default glyphicon glyphicon-play" onclick="updateTaskStatus('<? echo $task->id ?>','to start')"></button> -->
            <!-- <button class="btn btn-default glyphicon glyphicon-stop" onclick="updateTaskStatus('<? echo $task->id ?>','to stop')"></button> -->

            <? if ($task->template) : ?>
              <a href="/insert?env=<? echo substr($env, 1) ?>&parent=<? echo $task->id ?>" class="btn btn-default glyphicon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12">
                  <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                  <path d="M384 96L384 0h-112c-26.51 0-48 21.49-48 48v288c0 26.51 21.49 48 48 48H464c26.51 0 48-21.49 48-48V128h-95.1C398.4 128 384 113.6 384 96zM416 0v96h96L416 0zM192 352V128h-144c-26.51 0-48 21.49-48 48v288c0 26.51 21.49 48 48 48h192c26.51 0 48-21.49 48-48L288 416h-32C220.7 416 192 387.3 192 352z" />
                </svg>
              </a>
            <? endif ?>
            <a href="/update?env=<? echo substr($env, 1) ?>&id=<? echo $task->id ?>" class="btn btn-default glyphicon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12">
                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                <path d="M362.7 19.32C387.7-5.678 428.3-5.678 453.3 19.32L492.7 58.75C517.7 83.74 517.7 124.3 492.7 149.3L444.3 197.7L314.3 67.72L362.7 19.32zM421.7 220.3L188.5 453.4C178.1 463.8 165.2 471.5 151.1 475.6L30.77 511C22.35 513.5 13.24 511.2 7.03 504.1C.8198 498.8-1.502 489.7 .976 481.2L36.37 360.9C40.53 346.8 48.16 333.9 58.57 323.5L291.7 90.34L421.7 220.3z" />
              </svg>
            </a>
            <a href="/list?env=<? echo substr($env, 1) ?>&id=<? echo $task->id ?>" class="btn btn-default glyphicon glyphicon-th-list"></a>
            <button class="btn btn-default glyphicon glyphicon-trash" onclick="deleteTask('<? echo $task->id ?>')"></button>
          </div>
        </td>
      </tr>
      <tr class="collapse">
        <td class="panel panel-primary" colspan="999">
          <div class="panel-body">
            <table class="table table-striped table-bordered table-hover table-condensed">
              <thead>
                <tr>
                  <th width="200"></th>
                  <th>total</th>
                  <th>scan</th>
                  <th>list</th>
                  <th>content</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>抓取的URL数量</td>
                  <td><? echo $task->collected_urls_num ?: 0 ?> / <? echo $task->collect_urls_num ?: 0 ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>当前进程采集成功数</td>
                  <td><? echo $task->collect_succ ?: 0 ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>当前进程采集失败数</td>
                  <td><? echo $task->collect_fail ?: 0 ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>提取到的字段数</td>
                  <td><? echo $task->fields_num ?: 0 ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </td>
      </tr>
    <? endforeach; ?>
  </tbody>
</table>

<div class="modal fade" id="modalForUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">迁移数据</h4>
      </div>
      <div class="modal-body">
        <textarea class="form-control" name="upload" rows="10"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="uploadTaskList()">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
  function updateTaskStatus(id, status) {
    $.ajax({
      url: "/update",
      method: "post",
      data: {
        id,
        status,
      },
      success(res) {
        alert("修改成功");
        window.location.reload()
      }
    })
  }

  function deleteTask(id) {
    $.ajax({
      url: "/delete",
      method: "post",
      data: {
        id
      },
      success(res) {
        alert("删除成功");
        window.location.reload();
      }
    })
  }

  function startTask() {
    $.ajax({
      url: "/start",
      method: "post",
      data: {},
      success(res) {}
    })
  }

  function uploadTaskList() {
    const data = JSON.parse($("textarea[name='upload']").val());
    $.ajax({
      url: "/upload",
      method: "POST",
      data: {
        list: data,
      },
      success(res) {
        alert("数据上传成功");
        window.location.href = "/";
      },
    })
  }
</script>