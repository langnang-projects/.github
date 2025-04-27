<?php

/**
 * 爬虫执行文件
 * start: php -f PhpSpider.php start {$key} {$mode} {$env}
 * @param id 需要执行的任务
 * @param mode create | insert | update | replace
 * @param staus to start | starting | started | running | to pause | paused | to stop | stopping | stopped
 */


parse_str(implode("&", $argv), $_CLI_ARGV);
unset($_CLI_ARGV['start']);
// 检测配置变量
if (!isset($_CLI_ARGV['id'])) {
  echo "变量不足，程序启动失败";
  return "变量不足，程序启动失败";
}

$id = $_CLI_ARGV['id'];
$mode = ($_CLI_ARGV['mode']) ?: 'default';
$env = ($_CLI_ARGV['env']) ? ("." . $_CLI_ARGV['env']) : '';

require_once __DIR__ . '/vendor/autoload.php';

use phpspider\core\db;
use phpspider\core\log;
use phpspider\core\selector;
use Langnang\PhpSpiderConfigModel;
use Langnang\PhpSpiderController;


$env_config = parse_ini_file(__DIR__ . "/.env{$env}", true);
$env_config_fields = [];
foreach ($env_config as $key => $value) {
  if (strpos($key, 'fields.') !== false) {
    $env_config_fields[substr($key, 7)] = $value;
    unset($env_config[$key]);
  }
}
$db_config = $env_config['db_config'];
$tbname = "phpspider";
// var_dump($db_config);
// 数据库配置
db::set_connect('default', $db_config);
// 数据库链接
db::_init();

$config = db::get_one("SELECT * FROM `{$tbname}` WHERE `id` = '{$id}'");

if (is_null($config)) {
  echo "未找到指定任务";
  return "未找到指定任务";
}
$config = new PhpSpiderConfigModel($config);
// print_r($config);
/* Do NOT delete this comment */
/* 不要删除这段注释 */
// file_put_contents(__DIR__ . "/._config.json", json_encode($config));
// var_dump($task);
// $configs = merge_option($task);

// $config->__construct(array_merge(
//   parse_ini_file(__DIR__ . "/.env", true),
//   ["fields" => parse_ini_file(__DIR__ . "/.env.fields", true),]
// ), true);

// $config->__construct($_CLI_ARGV);
$config = $config->__to_array();
$config = array_merge($config, $env_config);
$config["fields"] = array_merge($config["fields"], $env_config_fields);
// print_r($config);
// exit;
// print_r($config);
// exit();
// print_r($configs['max_fields']);
// print_r($configs['export']);
// if ($mode == 'create') {
//   if ($configs["export"]["type"] == 'db') {
//     create_mode($configs);
//   }
// }
print_r($config);
// file_put_contents(__DIR__ . "/.config.json", json_encode($configs));


$spider = new PhpSpiderController();
/** 爬虫初始化时调用, 用来指定一些爬取前的操作
 * @param $phpspider 爬虫对象
 */
$spider->on_start = function ($phpspider) use ($id) {
  file_put_contents($phpspider->get_config('log_file'), '');

  // print_r($phpspider::$configs);
  log::debug("on_start: {$phpspider->get_config('name')}");
  // 重置日志文件内容
  // 更新状态
  // exit();
  // Requests::post($update_url, array("Content-Type" => "application/json"), json_encode(array("id" => $id, "status" => 9)));
};
/** 根据网页的请求返回的HTTP状态码判断是否被拦截
 * 
 */
$spider->on_status_code = function ($status_code, $url, $content, $phpspider) {
  log::debug("on_status_code[{$status_code}]: {$url}");

  // 如果状态码为429，说明对方网站设置了不让同一个客户端同时请求太多次
  if ($status_code == '429') {
    // 将url插入待爬的队列中,等待再次爬取
    $phpspider->add_url($url);
    // 当前页先不处理了
    return false;
  }
  // 不拦截的状态码这里记得要返回，否则后面内容就都空了
  return $content;
};
/** 判断当前网页是否被反爬虫了, 需要开发者实现
 * 
 */
$spider->is_anti_spider = function ($url, $content, $phpspider) {
  log::debug("is_anti_spider: {$url}");
  // $content中包含"404页面不存在"字符串
  if (strpos($content, "404页面不存在") !== false) {
    // 如果使用了代理IP，IP切换需要时间，这里可以添加到队列等下次换了IP再抓取
    // $phpspider->add_url($url);
    return true; // 告诉框架网页被反爬虫了，不要继续处理它
  }
  // 当前页面没有被反爬虫，可以继续处理
  return false;
};
/** 在一个网页下载完成之后调用. 主要用来对下载的网页进行处理.
 * @param $page 当前下载的网页页面的对象
 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象
 * @param $phpspider 爬虫对象
 * @return 返回处理后的网页内容
 */
$spider->on_download_page = function ($page, $phpspider) {
  log::debug("on_download_page: {$page['url']}");
  file_put_contents(__DIR__ . "/.html", $page["raw"]);
  return $page;
};
/** 在爬取到入口url的内容之后, 添加新的url到待爬队列之前调用. 主要用来发现新的待爬url, 并且能给新发现的url附加数据
 * @param $page 当前下载的网页页面的对象
 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象
 * @param $content 当前网页内容
 * @param $phpspider 当前爬虫对象
 * @return 返回false表示不需要再从此网页中发现待爬url
 */
$spider->on_scan_page = function ($page, $content, $phpspider) {
  log::debug("on_scan_page: {$page['url']}");
  return true;
};
/** 在爬取到入口url的内容之后, 添加新的url到待爬队列之前调用. 主要用来发现新的待爬url, 并且能给新发现的url附加数据
 * @param $page 当前下载的网页页面的对象
 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象
 * @param $content 当前网页内容
 * @param $phpspider 当前爬虫对象
 * @return 返回false表示不需要再从此网页中发现待爬url
 */
$spider->on_list_page = function ($page, $content, $phpspider) {
  log::debug("on_list_page: {$page['url']}");
  return true;
};
/** 在爬取到入口url的内容之后, 添加新的url到待爬队列之前调用. 主要用来发现新的待爬url, 并且能给新发现的url附加数据
 * @param $page 当前下载的网页页面的对象
 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象
 * @param $content 当前网页内容
 * @param $phpspider 当前爬虫对象
 * @return 返回false表示不需要再从此网页中发现待爬url
 */
$spider->on_content_page = function ($page, $content, $phpspider) {
  log::debug("on_content_page: {$page['url']}");
  return true;
};
/** 在一个网页下载完成之后调用. 主要用来对下载的网页进行处理.
 * on_download_attached_page($content, $phpspider)
 * @param $content 当前下载的网页内容
 * @param $phpspider 爬虫对象
 * @return 返回处理后的网页内容
 */
$spider->on_download_attached_page = function ($content, $phpspider) {
  return $content;
};

/** 在一个网页获取到URL之后调用. 主要用来对获取到的URL进行处理.
 * on_fetch_url($url, $phpspider)
 * @param $url 当前获取到的URL
 * @param $phpspider 爬虫对象
 * @return 返回处理后的URL，为false则此URL不入采集队列
 */
$spider->on_fetch_url = function ($url, $phpspider) {
  if ($phpspider->is_content_page($url)) {
    if ($phpspider->on_fetch_content_url) {
      $return = call_user_func($phpspider->on_fetch_content_url, $url, $phpspider);
    }
  } elseif ($phpspider->is_list_page($url)) {
    if ($phpspider->on_fetch_list_url) {
      $return = call_user_func($phpspider->on_fetch_list_url, $url, $phpspider);
    }
  } elseif ($phpspider->is_scan_page($url)) {
    if ($phpspider->on_fetch_scan_url) {
      $return = call_user_func($phpspider->on_fetch_scan_url, $url, $phpspider);
    }
  } else {
    log::debug("on_fetch_url: {$url}");
  }
  $url = isset($return) ? $return : $url;
  unset($return);
  return $url;
};
$spider->on_fetch_scan_url = function ($url, $phpspider) {
  log::debug("on_fetch_scan_url: {$url}");
};
$spider->on_fetch_list_url = function ($url, $phpspider) {
  log::debug("on_fetch_list_url: {$url}");
};
$spider->on_fetch_content_url = function ($url, $phpspider) {
  log::debug("on_fetch_content_url: {$url}");
};
/** 当一个field的内容被抽取到后进行的回调, 在此回调中可以对网页中抽取的内容作进一步处理
 * 
 * @param $fieldname 当前field的name. 注意: 子field的name会带着父field的name, 通过.连接.
 * @param $data 当前field抽取到的数据. 如果该field是repeated, data为数组类型, 否则是String
 * @param $page 当前下载的网页页面的对象
 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象
 * @return 返回处理后的数据, 注意数据类型需要跟传进来的$data类型匹配
 * 
 */
$spider->on_extract_field = function ($fieldname, $data, $page) use ($spider) {
  log::debug("on_extract_field: {$fieldname}");
  // 转字符串，便于存储
  if (is_array($data)) {
    return json_encode($data, JSON_UNESCAPED_UNICODE);
  }
  // 非空直接返回
  if ($data != "") {
    return $data;
  }
  // 检索判断是否存在替换的原始数据
  $fields = array_filter($spider->get_config("fields"), function ($e) use (&$fieldname) {
    return $e["name"] == $fieldname;
  });
  $field = array_shift($fields);
  switch ($field["selector"]) {
    case "url":
      $data = $page["url"];
      break;
    case "title":
      $data = selector::select($page['raw'], "//title");
      break;
    case "metas":
      break;
    case "raw":
      $data = $page["raw"];
      break;
    case "request":
      $data = json_encode($page["request"], JSON_UNESCAPED_UNICODE);
      break;
    case "current_time":
      $data = time();
      break;
    case "current_timestamp":
      $data = date("Y-m-d H:i:s", time());
      break;
    default:
      break;
  };
  return $data;
};
/** 在一个网页的所有field抽取完成之后, 可能需要对field进一步处理, 以发布到自己的网站
 * @param $page 当前下载的网页页面的对象
 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象
 * @param $data 当前网页抽取出来的所有field的数据
 * @return 返回处理后的数据, 注意数据类型需要跟传进来的$data类型匹配
 */
$spider->on_extract_page = function ($page, $data) use ($spider, $id, &$count_fields_num) {
  log::debug("on_extract_page: {$page['url']}");
  $count_fields_num++;
  log::debug("on_count_fields_num: {$count_fields_num}");
  if ($spider->get_config('max_fields') != 0 && $count_fields_num > $spider->get_config('max_fields')) {
    log::debug("on_extract_max_pages: {$count_fields_num}");
  }
  return $data;
};

$spider->__construct($config);

require_once __DIR__ . "/mode.php";
// var_dump($spider->get_config('log_show'));
$spider->start();
