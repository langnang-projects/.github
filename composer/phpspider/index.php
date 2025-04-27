<?php

require_once __DIR__ . '/vendor/autoload.php';
// use phpspider\core\phpspider;
// use phpspider\web\phpspider;

// dump(get_declared_classes());

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// dump($dotenv);
// dump($_ENV);
// dump($_SERVER);

// 生成非对称加密密钥对
$config = array(
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);
$res = openssl_pkey_new($config);
// 提取私钥
// openssl_pkey_export($res, $privKey);

// 提取公钥
// $pubKey = openssl_pkey_get_details($res);
// $pubKey = $pubKey["key"];
// dump([$res, $privKey, $pubKey]);
use phpspider\core\db;

// $configs = require __DIR__ . '/configs/a5xiazai.php';

// $configs['export'] = ['type' => 'csv', 'file' => './data/' . $configs['name'] . '.csv'];

// var_dump($configs);

// $spider = new phpspider($configs);

// $spider->on_download_page = function ($page, $phpspider) {
//   // $page_html = "<div id=\"comment-pages\"><span>5</span></div>";
//   // $index = strpos($page['row'], "</body>");
//   // $page['raw'] = substr($page['raw'], 0, $index) . $page_html . substr($page['raw'], $index);
//   var_dump($page);
//   return $page;
// };

// // var_dump($spider);
// $spider->start();

?>

<?php include_once __DIR__ . '/views/index.php'; ?>