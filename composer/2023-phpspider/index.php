<?php

/**
 * 判断是否存在全局配置
 */

$env = $_GET["env"] ? (".{$_GET['env']}") : '';
$route_path = substr($_SERVER['PATH_INFO'], 1);
if (!file_exists(__DIR__ . "/.env{$env}") && $route_path !== 'install') {
  Header("Location: /install?env={$_GET['env']}");
  exit;
}
require_once __DIR__ . '/vendor/autoload.php';
// require_once(__DIR__ . "/helper.php");

// var_dump(get_class_vars('PhpSpiderConfigModel'));

use Langnang\PhpSpiderConfigModel;
use Langnang\PhpSpiderController;
use phpspider\core\db;
use Langnang\lnArray;

session_start();

$tbname = "phpspider";


if ($route_path !== 'install') {
  $env_config = parse_ini_file(__DIR__ . "/.env{$env}", true);

  $db_config = $env_config['db_config'];

  // 数据库配置
  db::set_connect('default', $db_config);
  // 数据库链接
  db::_init();
  // 检测数据表是否存在
  if (empty(db::get_all("SHOW TABLES LIKE '{$tbname}'"))) {
    $sql = "CREATE TABLE `{$tbname}`  (
      `id` varchar(13) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ID',
      `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标签、关键字',
      `template` tinyint(1) NULL DEFAULT NULL COMMENT '是否为模板',
      `parent` varchar(13) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '使用的模板ID',
      `status` int(1) NULL DEFAULT NULL COMMENT '任务执行状态\r\n-1待运行\r\n1:运行中\r\n-9:待停止\r\n0:已停止',
      `mode` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '任务执行模式\r\ndefault: 只增+条件更新\r\ncreate: 创建模式\r\ninsert: 新增模式\r\nupdate: 更新模式',
      `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '定义当前爬虫名称',
      `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '爬虫任务描述',
      `log_show` tinyint(1) NULL DEFAULT NULL COMMENT '是否显示日志\r\n为true时显示调试信息\r\n为false时显示爬取面板',
      `log_file` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '日志文件路径',
      `log_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '显示和记录的日志类型\r\n普通类型: info\r\n警告类型: warn\r\n调试类型: debug\r\n错误类型: error',
      `input_encoding` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '输入编码\r\n明确指定输入的页面编码格式(UTF-8,GB2312,…..)，防止出现乱码,如果设置null则自动识别',
      `output_encoding` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '输出编码\r\n明确指定输出的编码格式(UTF-8,GB2312,…..)，防止出现乱码,如果设置null则为utf-8',
      `tasknum` int(10) NULL DEFAULT NULL COMMENT '同时工作的爬虫任务数\r\n需要配合redis保存采集任务数据，供进程间共享使用',
      `multiserver` tinyint(1) NULL DEFAULT NULL COMMENT '多服务器处理\r\n需要配合redis来保存采集任务数据，供多服务器共享数据使用',
      `serverid` int(10) NULL DEFAULT NULL COMMENT '服务器ID',
      `save_running_state` tinyint(1) NULL DEFAULT NULL COMMENT '保存爬虫运行状态\r\n需要配合redis来保存采集任务数据，供程序下次执行使用\r\n注意：多任务处理和多服务器处理都会默认采用redis，可以不设置这个参数',
      `queue_config` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'redis配置',
      `proxy` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '代理服务器\r\n如果爬取的网站根据IP做了反爬虫, 可以设置此项',
      `interval` int(10) NULL DEFAULT NULL COMMENT '爬虫爬取每个网页的时间间隔\r\n单位：毫秒',
      `timeout` int(10) NULL DEFAULT NULL COMMENT '爬虫爬取每个网页的超时时间\r\n单位：秒',
      `max_try` int(10) NULL DEFAULT NULL COMMENT '爬虫爬取每个网页失败后尝试次数\r\n网络不好可能导致爬虫在超时时间内抓取失败, 可以设置此项允许爬虫重复爬取',
      `max_depth` int(10) NULL DEFAULT NULL COMMENT '爬虫爬取网页深度，超过深度的页面不再采集\r\n对于抓取最新内容的增量更新，抓取好友的好友的好友这类型特别有用',
      `max_fields` int(10) NULL DEFAULT NULL COMMENT '爬虫爬取内容网页最大条数\r\n抓取到一定的字段后退出',
      `user_agent` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '爬虫爬取网页所使用的浏览器类型\r\nphpspider::AGENT_ANDROID\r\nphpspider::AGENT_IOS\r\nphpspider::AGENT_PC\r\nphpspider::AGENT_MOBILE',
      `client_ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '爬虫爬取网页所使用的伪IP，用于破解防采集',
      `export` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '爬虫爬取数据导出\r\n\r\ntype：导出类型 csv、sql、db\r\nfile：导出 csv、sql 文件地址\r\ntable：导出db、sql数据表名',
      `db_config` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '数据库配置',
      `domains` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '定义爬虫爬取哪些域名下的网页, 非域名下的url会被忽略以提高爬取速度',
      `scan_urls` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '定义爬虫的入口链接, 爬虫从这些链接开始爬取,同时这些链接也是监控爬虫所要监控的链接',
      `list_url_regexes` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '定义列表页url的规则\r\n对于有列表页的网站, 使用此配置可以大幅提高爬虫的爬取速率\r\n列表页是指包含内容页列表的网页',
      `content_url_regexes` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '定义内容页url的规则\r\n内容页是指包含要爬取内容的网页',
      `fields` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '定义内容页的抽取规则\r\n规则由一个个field组成, 一个field代表一个数据抽取项',
      `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
    ) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = FIXED;";
  }
}

if ($route_path === 'download') {
  $rows = db::get_all("SELECT * FROM `$tbname`");
  echo json_encode($rows, JSON_UNESCAPED_UNICODE);
  return;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  parse_str(file_get_contents("php://input"), $data);
  switch ($route_path) {
    case "install":
      // 登录&设置密码
      if (isset($data["password"])) {
        $env_config = file_exists(__DIR__ . "/.env{$env}") ? parse_ini_file(__DIR__ . "/.env{$env}", true) : [];
        // 文件存在：登录
        if (!isset($env_config["password"])) {
          $env_config["password"] = md5($data["password"]);
          file_put_contents(__DIR__ . "/.env{$env}", lnArray::to_ini($env_config));
        } else {
          if ($env_config["password"] == md5($data["password"])) {
            //  当验证通过后，启动 Session
            session_start();
            //  注册登陆成功的 admin 变量，并赋值 true
            $_SESSION["admin"] = true;
            $_SESSION["env"] = $env;
            die("登录成功[" . substr($env, 1) . "]");
          } else {
            die("密码错误");
          }
        }
      } else {
        if (isset($data["db_config"])) {
          // 创建连接
          $conn = mysqli_connect($data["db_config"]['host'], $data["db_config"]['user'], $data["db_config"]['pass'], $data["db_config"]['name'], $data["db_config"]['port']);

          // 检测连接
          if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
          }
          mysqli_close($conn);
        }
        // 设置全局配置
        $env_config = file_exists(__DIR__ . "/.env{$_SESSION['env']}") ? parse_ini_file(__DIR__ . "/.env{$_SESSION['env']}", true) : [];
        $data["password"] = $env_config["password"];
        unset($data["parent"]);
        foreach ($data["fields"] as $index => $field) {
          $data["fields.{$index}"] = $field;
        }
        unset($data["fields"]);
        file_put_contents(__DIR__ . "/.env{$_SESSION['env']}", lnArray::to_ini($data));
      }
      break;
    case "logout":
      session_start();
      //  这种方法是将原来注册的某个变量销毁
      unset($_SESSION['admin']);
      unset($_SESSION['env']);
      //  这种方法是销毁整个 Session 文件
      session_destroy();
      break;
    case "insert":
      $env_config = file_exists(__DIR__ . "/.env{$env}") ? parse_ini_file(__DIR__ . "/.env{$env}", true) : [];
      $config = new PhpSpiderConfigModel(array_merge($env_config, $data));
      $config->id = uniqid();
      $config = $config->__to_array(false);
      db::insert($tbname, $config);
      break;
    case "upload":
      $env_config = file_exists(__DIR__ . "/.env{$env}") ? parse_ini_file(__DIR__ . "/.env{$env}", true) : [];
      $data["list"] = array_map(function ($item) use ($env_config) {
        $item = new PhpSpiderConfigModel(array_merge($env_config, $item));
        $item->set_id();
        return $item->__to_array(false);
      }, $data["list"]);
      db::insert_batch($tbname, $data['list']);
      break;
    case "delete":
      db::delete($tbname, "`id` = '{$data['id']}'");
      break;
    case "update":
      if (!isset($_GET['id'])) return false;
      $env_config = file_exists(__DIR__ . "/.env{$env}") ? parse_ini_file(__DIR__ . "/.env{$env}", true) : [];
      $data["id"] = $_GET['id'];
      $config = new PhpSpiderConfigModel(array_merge($env_config, $data));
      $config = $config->__to_array(false);
      unset($config["time"]);
      $result = db::update($tbname, $config, "`id` = '{$config['id']}'");
      break;
    default:
      break;
  }
  return;
}

?>
<? if ($_SERVER['REQUEST_METHOD'] === 'GET') : ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhpSpider - Langnang</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  </head>

  <body>
    <div class="container">
      <h1 class="text-center">PhpSpider</h1>
    <? endif ?>
    <?
    switch ($route_path) {
      case "insert":
      case "update":
      case "install":
        require_once __DIR__ . "/views/option-form.php";
        break;
      case "list":
        require_once __DIR__ . "/views/field-table.php";
        break;
      default:
        require_once __DIR__ . "/views/task-table.php";
        break;
    }
    ?>
    <? if ($_SERVER['REQUEST_METHOD'] === 'GET') : ?>
      <ul>
        <li><a target="_blank" href="https://doc.phpspider.org/">PHP蜘蛛爬虫开发文档</a></li>
        <li><a target="_blank" href="https://regex101.com/">regex101</a></li>
        <li><a target="_blank" href="https://www.w3school.com.cn/xpath/index.asp">xPath 教程</a></li>
      </ul>
    </div>
    <script>
      function toggleCollapse(e) {
        const tbody = $(e).closest('tbody');
        // console.log(tbody);
        const index = $(e).closest('tr').index() / 2;
        // console.log(index);
        $(".collapse").eq(index).collapse('toggle');
      }
    </script>
  </body>

  </html>
<? endif ?>