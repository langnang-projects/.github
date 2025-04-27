<?php

require_once __DIR__ . '/core/util.php';
require_once __DIR__ . '/core/requests.php';
require_once __DIR__ . '/core/selector.php';
require_once __DIR__ . '/core/db.php';
require_once __DIR__ . '/core/log.php';
require_once __DIR__ . '/core/phpspider.php';


set_time_limit(0); //设置程序执行时间
// ignore_user_abort(true); //设置断开连接继续执行
header('X-Accel-Buffering: no'); //关闭buffer
header('Content-type: text/html;charset=utf-8'); //设置网页编码

$_ENV = parse_ini_file(__DIR__ . '/.env');
// var_dump($_ENV);

$configs = json_decode(file_get_contents(__DIR__ . '/../../../../../storage/data/phpspider.json'), true);
$contents = $configs['contents'];


switch (strtolower($_SERVER["PATH_INFO"])) {
    case "":
    case "/":
        require_once __DIR__ . '/views/default/index.php';
        break;
    case "/content";
        require_once __DIR__ . '/views/default/content.php';
        break;
    case "/ob-spider";
        require_once __DIR__ . '/views/default/ob-spider.php';
        break;
    default:
        break;
}
?>

<?php

ob_start(); //打开输出缓冲控制
echo str_repeat(' ', 1024 * 4); //字符填充
$width = 1000;
// $html = '<div style="margin:100px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx"><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg" style="font-family: Tahoma; font-size: 9pt;">正在处理...</div><div id="percent" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%%</div></div>';
// echo sprintf($html, $width + 8, $width);
echo ob_get_clean(); //获取当前缓冲区内容并清除当前的输出缓冲
flush(); //刷新缓冲区的内容，输出
$length = 11;
// for ($i = 0; $i < $length; $i++) {
//     sleep(rand(1, 2));
//     $proportion = ($i + 1) / $length;
//     if ($i + 1 == $length) {
//         $msg = '同步完成';
//     } else {
//         $msg = '正在同步第' . ($i + 1) . '个用户';
//     }
//     $script = '<script>
//         document.getElementById("percent").innerText = "%u%%";
//         document.getElementById("progress").style.width = "%upx";
//         document.getElementById("msg").innerText = "%s";
//       </script>';
//     echo sprintf($script, intval($proportion * 100), intval(($i + 1) / $length) * $width, $msg);
//     echo ob_get_clean(); //获取当前缓冲区内容并清除当前的输出缓冲
//     flush(); //刷新缓冲区的内容，输出
// }
// $spider->start();
?>