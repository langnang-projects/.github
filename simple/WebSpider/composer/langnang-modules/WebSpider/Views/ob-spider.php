<?php
set_time_limit(0); //设置程序执行时间
// ignore_user_abort(true); //设置断开连接继续执行
header('X-Accel-Buffering: no'); //关闭buffer
header('Content-type: text/html;charset=utf-8'); //设置网页编码


$config['callback'] = function ($phpspider) {
  // var_dump("callback", [

  //   'collect_urls_num' => $phpspider->collect_urls_num,
  //   'collect_scan_urls_num' => $phpspider->collect_scan_urls_num,
  //   'collect_list_urls_num' => $phpspider->collect_list_urls_num,
  //   'collect_content_urls_num' => $phpspider->collect_content_urls_num,

  //   'collected_urls_num' => $phpspider->collected_urls_num,
  //   'collected_scan_urls_num' => $phpspider->collected_scan_urls_num,
  //   'collected_list_urls_num' => $phpspider->collected_list_urls_num,
  //   'collected_content_urls_num' => $phpspider->collected_content_urls_num,

  //   'collect_succ' => $phpspider->collect_succ,
  //   'collect_fail' => $phpspider->collect_fail,

  //   'fields_num' => $phpspider->fields_num,
  //   'collect_succ' => $phpspider->collect_succ,

  //   // 'collect_urls' => $phpspider->collect_urls,
  //   'collect_urls_num' => sizeof($phpspider->collect_urls),
  //   // 'collect_queue' => $phpspider->collect_queue,
  //   'collect_queue_num' => sizeof($phpspider->collect_queue),
  // ]);
  $script = '<script>
  document.querySelector(".table").innerHTML = `<table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">入口页</th>
        <th scope="col">列表页</th>
        <th scope="col">内容页</th>
        <th scope="col">字段数</th>
        <th scope="col">总计</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">#</th>
        <td>%u / %u</td>
        <td>%u / %u</td>
        <td>%u / %u</td>
        <td>%u / %u / %u</td>
        <td>%u / %u</td>
      </tr>
    </tbody>
  </table>`;
</script>';
  echo sprintf(
    $script,
    $phpspider->collected_scan_urls_num,
    $phpspider->collect_scan_urls_num,
    $phpspider->collected_list_urls_num,
    $phpspider->collect_list_urls_num,
    $phpspider->collected_content_urls_num,
    $phpspider->collect_content_urls_num,
    $phpspider->inserted_fields_num,
    $phpspider->updated_fields_num,
    $phpspider->fields_num,
    $phpspider->collected_urls_num,
    $phpspider->collect_urls_num,
  );
  echo ob_get_clean(); //获取当前缓冲区内容并清除当前的输出缓冲
  flush(); //刷新缓冲区的内容，输出
};
require_once __DIR__ . '/phpspider.php';

?>
<?php require_once __DIR__ . '/layout/head.php'; ?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<main class="container">
  <h1 class="text-center">Bootstrap v4</h1>
  <div class="jumbotron mb-3">
    <h1 class="display-4">Hello, world!</h1>
    <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
    <hr class="my-4">
    <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
    <a class="btn btn-secondary btn-lg" href="../<?php _e(config('this.alias')) ?>/content?<?php echo $_SERVER['QUERY_STRING']; ?>" role="button">Return</a>
  </div>
  <div class="progress mb-3" style="height: 2.5rem;">
    <div class="progress-bar progress-bar-striped progress-bar-animated text-left pl-3" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;font-size: 200%;">0%</div>
  </div>

  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">入口页</th>
        <th scope="col">列表页</th>
        <th scope="col">内容页</th>
        <th scope="col">字段数</th>
        <th scope="col">总计</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">#</th>
        <td>0 / 0</td>
        <td>0 / 0</td>
        <td>0 / 0</td>
        <td>0 / 0 / 0</td>
        <td>0 / 0</td>
      </tr>
    </tbody>
  </table>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>

<?php require_once __DIR__ . '/layout/foot.php'; ?>

<?php
ob_start(); //打开输出缓冲控制
echo ob_get_clean(); //获取当前缓冲区内容并清除当前的输出缓冲
$width = 1000;
$length = 11;
// for ($i = 0; $i < $length; $i++) {
//   sleep(rand(1, 2));
//   $pct = 100 / $length * ($i + 1);
//   $proportion = ($i + 1) / $length;
//   if ($i + 1 == $length) {
//     $msg = '同步完成';
//   } else {
//     $msg = '正在同步第' . ($i + 1) . '个用户';
//   }
//   $script = '<script>
//         document.querySelector(".progress-bar").style.width = "%u%%";
//         document.querySelector(".progress-bar").innerHTML = "\n\n\n%u%%";
//       </script>';
//   echo sprintf($script, intval($pct), intval($pct));
//   echo ob_get_clean(); //获取当前缓冲区内容并清除当前的输出缓冲
//   flush(); //刷新缓冲区的内容，输出
// }


$spider->start();
