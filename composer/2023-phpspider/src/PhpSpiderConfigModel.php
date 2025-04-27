<?

namespace Langnang;

class PhpSpiderConfigModel extends lnModel
{
  /**
   * 编号
   */
  public $id;
  /**
   * 模式：default | create | update
   */
  public $mode = "default";
  /**
   * 数据源
   */
  // public $source = "";
  /**
   * 编码，也用作数据表名
   */
  // public $key = "phpspider";
  // 状态
  public $status = 0;
  /** 
   * 定义当前爬虫名称
   */
  public $name = "phpspider";
  /**
   * 
   */
  public $description = "";

  /**
   * 关键字
   */
  public $keywords = [];
  /**
   * 是否为配置模板
   */
  public $template = false;
  /**
   * 如果使用了模板，则为模板ID，否则为空
   */
  public $parent;

  // 是否显示日志
  // 为true时显示调试信息
  // 为false时显示爬取面板
  // 布尔类型 可选设置
  // log_show默认值为false，即显示爬取面板
  public $log_show = false;
  // 日志文件路径
  // String类型 可选设置
  // log_file默认路径为data/phpspider.log
  public $log_file = ".log";
  // 显示和记录的日志类型
  // 普通类型: info
  // 警告类型: warn
  // 调试类型: debug
  // 错误类型: error
  // String类型 可选设置
  // log_type默认值为空，即显示和记录所有日志类型
  public $log_type = 'error';
  // 输入编码
  // 明确指定输入的页面编码格式(UTF-8,GB2312,…..)，防止出现乱码,如果设置null则自动识别
  // String类型 可选设置
  // input_encoding默认值为null，即程序自动识别页面编码
  public $input_encoding = 'UTF-8';
  // 输出编码
  // 明确指定输出的编码格式(UTF-8,GB2312,…..)，防止出现乱码,如果设置null则为utf-8
  // String类型 可选设置
  // output_encoding默认值为utf-8, 如果数据库为gbk编码，请修改为gb2312
  public $output_encoding = 'UTF-8';
  // 同时工作的爬虫任务数
  // 需要配合redis保存采集任务数据，供进程间共享使用
  // 整型 可选设置
  // tasknum默认值为1，即单进程任务爬取
  public $tasknum = 1;
  // 多服务器处理
  // 需要配合redis来保存采集任务数据，供多服务器共享数据使用
  // 布尔类型 可选设置
  // multiserver默认值为false
  public $multiserver = false;
  // 服务器ID
  // 整型 可选设置
  // serverid默认值为1
  public $serverid = 1;
  // 保存爬虫运行状态
  // 需要配合redis来保存采集任务数据，供程序下次执行使用
  // 注意：多任务处理和多服务器处理都会默认采用redis，可以不设置这个参数
  // 布尔类型 可选设置
  // save_running_state默认值为false，即不保存爬虫运行状态
  public $save_running_state = false;
  // redis配置
  // 数组类型 可选设置
  // 保存爬虫运行状态、多任务处理 和 多服务器处理 都需要redis来保存采集任务数据
  public $queue_config = [
    'host'      => '127.0.0.1',
    'port'      => 6379,
    'pass'      => '',
    'db'        => 5,
    'prefix'    => 'phpspider',
    'timeout'   => 30,
  ];
  // 代理服务器
  // 如果爬取的网站根据IP做了反爬虫, 可以设置此项
  // 数组类型 可选设置
  public $proxy = [];
  // 爬虫爬取每个网页的时间间隔
  // 单位：毫秒
  // 整型 可选设置
  public $interval = 1;
  // 爬虫爬取每个网页的超时时间
  // 单位：秒
  // 整型 可选设置
  // timeout默认值为5秒
  public $timeout = 5;
  // 爬虫爬取每个网页失败后尝试次数
  // 网络不好可能导致爬虫在超时时间内抓取失败, 可以设置此项允许爬虫重复爬取
  // 整型 可选设置
  // max_try默认值为0，即不重复爬取
  public $max_try = 0;
  // 爬虫爬取网页深度，超过深度的页面不再采集
  // 对于抓取最新内容的增量更新，抓取好友的好友的好友这类型特别有用
  // 整型 可选设置
  // max_depth默认值为0，即不限制
  public $max_depth = 0;
  // 爬虫爬取内容网页最大条数
  // 抓取到一定的字段后退出
  // 整型 可选设置
  // max_fields默认值为0，即不限制
  public $max_fields = 0;
  // 爬虫爬取网页所使用的浏览器类型
  // phpspider::AGENT_ANDROID
  // phpspider::AGENT_IOS
  // phpspider::AGENT_PC
  // phpspider::AGENT_MOBILE
  // 枚举类型 可选设置
  // 'user_agent' => phpspider::AGENT_PC,
  // 爬虫爬取网页所使用的伪IP，用于破解防采集
  // String类型 或 数组类型 可选设置
  public $client_ip = [];
  // 爬虫爬取数据导出
  // type：导出类型 csv、sql、db
  // file：导出 csv、sql 文件地址
  // table：导出db、sql数据表名
  // 注意导出到数据库的表和字段要和上面的fields对应
  // 数组类型 可选设置
  public $export = [
    'type' => 'csv',
    'file' => "/.csv", // data目录下
    'table' => "phpspider",
  ];
  // 数据库配置
  public $db_config = [
    'host'  => '127.0.0.1',
    'port'  => 3306,
    'user'  => 'user',
    'pass'  => 'pass',
    'name'  => 'name',
  ];
  // 定义爬虫爬取哪些域名下的网页, 非域名下的url会被忽略以提高爬取速度
  // 数组类型 不能为空
  public $domains = [];
  // 定义爬虫的入口链接, 爬虫从这些链接开始爬取,同时这些链接也是监控爬虫所要监控的链接
  // 数组类型 不能为空
  public $scan_urls = [];
  // 定义列表页url的规则
  // 对于有列表页的网站, 使用此配置可以大幅提高爬虫的爬取速率
  // 列表页是指包含内容页列表的网页 比如http://www.qiushibaike.com/8hr/page/2/?s=4867046 就是糗事百科的一个列表页
  // 数组类型 正则表达式
  public $list_url_regexes = [];
  // 定义内容页url的规则
  // 内容页是指包含要爬取内容的网页 比如http://www.qiushibaike.com/article/115878724 就是糗事百科的一个内容页
  // 数组类型 正则表达式 最好填写以提高爬取效率
  public $content_url_regexes = [];
  // 定义内容页的抽取规则
  // 规则由一个个field组成, 一个field代表一个数据抽取项
  // 数组类型 不能为空
  public $fields = [];
  public $time;

  // function __construct($configs = [], $merge_flag = false)
  // {
  //   foreach (get_class_vars(__CLASS__) as $name => $default_value) {
  //     if (is_array($default_value) && is_string($configs[$name])) {
  //       $configs[$name] = json_decode($configs[$name], true);
  //     } else
  //     if (is_bool($default_value) && is_string($configs[$name])) {
  //       $configs[$name] = (bool)$configs[$name];
  //     } else
  //     if (is_int($default_value) && is_string($configs[$name])) {
  //       $configs[$name] = (int)$configs[$name];
  //     }
  //   }
  //   // foreach ([] as $name) {
  //   //   $this->{$name} = (bool)(isset($configs[$name]) ? (($configs[$name] == 'true' || $configs[$name] == 1) ? true : false) : $this->{$name});
  //   // }
  //   // foreach ([
  //   //   'id',
  //   //   'key',
  //   //   'parent',
  //   //   'description',
  //   //   'keywords',
  //   //   'source',
  //   //   'name',
  //   //   'log_file',
  //   //   'log_type',
  //   //   'input_encoding',
  //   //   'output_encoding',
  //   //   'tasknum',
  //   //   'serverid',
  //   //   'interval',
  //   //   'timeout',
  //   //   'max_try',
  //   //   'max_depth',
  //   //   'max_fields',
  //   //   'template',
  //   //   'log_show',
  //   //   'multiserver',
  //   //   'save_running_state',
  //   //   'status',
  //   // ] as $name) {
  //   //   $this->{$name} = isset($configs[$name]) ? $configs[$name] : $this->{$name};
  //   // }
  //   // isset($configs['queue_config']) ? $this->set_queue_config($configs['queue_config']) : null;
  //   // isset($configs['export']) ? $this->set_export($configs['export']) : $this->set_export();
  //   // isset($configs['db_config']) ? $this->set_db_config($configs['db_config']) : null;
  //   // foreach (['proxy', 'client_ip', 'domains', 'scan_urls', 'content_url_regexes', 'list_url_regexes', 'fields'] as $name) {
  //   //   if ($merge_flag) {
  //   //     $this->{$name} = isset($configs[$name]) ? array_merge($this->{$name}, $configs[$name]) : $this->{$name};
  //   //   } else {
  //   //     $this->{$name} = isset($configs[$name]) ? $configs[$name] : $this->{$name};
  //   //   }
  //   // }
  //   // $this->set_fields($this->fields);
  // }
  function __self__construct($configs, $merge_flag = false, ...$args)
  {
    // foreach (['proxy', 'client_ip', 'domains', 'scan_urls', 'content_url_regexes', 'list_url_regexes', 'fields'] as $name) {
    //   if (!is_array($configs[$name])) {
    //     $configs[$name] = json_decode($configs[$name], JSON_UNESCAPED_UNICODE);
    //   }
    //   if ($merge_flag) {
    //     $this->{$name} = isset($configs[$name]) ? array_merge($this->{$name},  $configs[$name]) : $this->{$name};
    //   } else {
    //     $this->{$name} = isset($configs[$name]) ? $configs[$name] : $this->{$name};
    //   }
    // }
    // $this->set_fields($this->fields);
  }
  function set_id($id = null)
  {
    if (empty($id)) {
      $this->id = uniqid();
    } else {
      $this->id = $id;
    }
  }
  function set_queue_config($queue_config)
  {
    foreach (['host', 'port',  'pass', 'db', 'prefix', 'timeout'] as $name) {
      $this->queue_config[$name] = isset($queue_config[$name]) ? $queue_config[$name] : $this->queue_config[$name];
    }
  }
  function set_export($export = [])
  {
    foreach (['type', 'file', 'is_cover'] as $name) {
      $this->export[$name] = isset($export[$name]) ? $export[$name] : $this->export[$name];
    }
    $this->export['table'] = (isset($export['table']) && trim($export['table']) !== '') ? $export['table'] : $this->key;
  }
  function set_db_config($db_config)
  {
    foreach (['host', 'port', 'user', 'pass', 'name'] as $name) {
      $this->db_config[$name] = isset($db_config[$name]) ? $db_config[$name] : $this->db_config[$name];
    }
  }
  function set_fields($fields)
  {
    $this->fields = array_map(function ($field) {
      return new PhpSpiderConfigFieldModel($field);
    }, $fields);
  }
}
