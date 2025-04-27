<?php
require_once __DIR__ . '/../vendor/autoload.php';

use phpspider\core\requests;

// $url = explode("/", $_SERVER['SERVER_PROTOCOL'])[0] . "://" . $_SERVER['HTTP_HOST'] . '/api/novel/source/select';
$url = "http://www.ymoxuan.org//search.htm?keyword=" . urlencode("永恒");
var_dump($url);
var_dump(urldecode("永恒"));
var_dump(urlencode("永恒"));
$html = requests::get($url);
var_dump($html);
