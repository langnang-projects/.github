<?php
$content = $contents[$_GET['slug']];

$content['db_config'] = [
    'host'  => $_ENV['DB_HOST'] ?? '127.0.0.1',
    'port'  => $_ENV['DB_PORT'] ?? 3306,
    'user'  => $_ENV['DB_USERNAME'] ?? 'root',
    'pass'  => $_ENV['DB_PASSWORD'] ?? 'root',
    'name'  => $_ENV['DB_DATABASE'] ?? 'demo',
];
$content['export'] = [
    'type' => 'db',
    'table' => "webspider_logs",
    'unique_column' => "url",
];
$content['max_fields'] = 3;
$config = $content;
$config['callback'] = function ($phpspider) {
    var_dump("callback", []);
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
        <a class="btn btn-secondary btn-lg" href="../index.php/content?<?php echo $_SERVER['QUERY_STRING']; ?>" role="button">Return</a>
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
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
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
//     sleep(rand(1, 2));
//     $pct = 100 / $length * ($i + 1);
//     $proportion = ($i + 1) / $length;
//     if ($i + 1 == $length) {
//         $msg = '同步完成';
//     } else {
//         $msg = '正在同步第' . ($i + 1) . '个用户';
//     }
//     $script = '<script>
//         document.querySelector(".progress-bar").style.width = "%u%%";
//         document.querySelector(".progress-bar").innerHTML = "\n\n\n%u%%";
//       </script>';
//     echo sprintf($script, intval($pct), intval($pct));
//     echo ob_get_clean(); //获取当前缓冲区内容并清除当前的输出缓冲
//     flush(); //刷新缓冲区的内容，输出
// }


$spider->start();
