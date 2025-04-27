<?php

require_once __DIR__ . '/../vendor/autoload.php';

use phpspider\core\requests;
use phpspider\core\selector;

$fileName = md5("https://www.lgyy.cc/vodtype/1.html");

$html = file_get_contents(__DIR__ . "/../cache/$fileName");
// var_dump($html);

$container = selector::select($html, "//*[contains(@class,'module-items')]");
var_dump($container[0]);

$container = selector::select($container[0], "//a");
var_dump($container);

$container = selector::select($container[0], "/..");
var_dump($container);
