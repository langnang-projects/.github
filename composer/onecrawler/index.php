<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/App.php';

// require_once __DIR__ . '/source/Novel.php';
// require_once __DIR__ . '/source/Video.php';

require_once __DIR__ . '/routes/api.php';
require_once __DIR__ . '/routes/web.php';
// require_once __DIR__ . '/routes/novel.php';
// require_once __DIR__ . '/routes/video.php';

use Langnang\PhpServer\App;

define("ROOT_PATH", __DIR__);

$config = require(__DIR__ . "/config.inc.php");


(new App($config))->start();
