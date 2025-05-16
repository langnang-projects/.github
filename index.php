<?php

$return = [];

$return['_SERVER'] = $_SERVER;
$uri = $return['uri'] = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// var_dump($_SERVER);
// echo PHP_EOL;
// var_dump($uri);
// echo PHP_EOL;
// var_dump(explode("/", $uri));
// echo PHP_EOL;
// var_dump(PHP_URL_PATH);
// var_dump($uri);
$exp_uri = $return['uri'] = explode("/", $uri);
// var_dump($exp_uri);
if (($uri !== '/' && $uri !== '/index.php') && sizeof($exp_uri) > 1) {
    $dir = $exp_uri[1];
    require_once __DIR__ . '/' . $dir . '/index.php';
} else {
    getfiles(__DIR__);
}
// if (($uri !== '/' && $uri !== '/index.php') && file_exists(__DIR__ . '/public' . $uri)) {
//     return false;
// }

// require_once __DIR__ . '/public/index.php';
function getfiles($path)
{
    foreach (scandir($path) as $afile) {
        if ($afile == '.' || $afile == '..' || $afile == 'vendor' || $afile[0] == '.' || $afile[0] == '_')
            continue;
        if (is_dir($path . '/' . $afile)) {
            echo '<a href="/' . $afile . '">' . $path . '/' . $afile . '</a><br />';
            // getfiles($path . '/' . $afile);
        } else {
            // echo $path . '/' . $afile . '<br />';
        }
    }
} //简单的demo,列出当前目录下所有的文件