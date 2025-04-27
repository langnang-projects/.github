<?php


return [
  /**
   * 爬虫爬取每个网页的时间间隔,0表示不延时, 单位: 毫秒
   */
  'interval' => 100,
  /**
   * 爬虫爬取每个网页的超时时间, 单位: 秒
   */
  'timeout' => 5,
  /**
   * 爬取失败次数, 不想失败重新爬取则设置为0
   */
  'max_try' => 0,
  /**
   * 爬虫爬取网页所使用的浏览器类型: pc/Mac、ios、android
   * 默认类型是PC
   */
  'agents' => [
    'default' => "pc",
    'options' => [
      'pc' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36',
      'ios' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_3_3 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13G34 Safari/601.1',
      'android' => 'Mozilla/5.0 (Linux; U; Android 6.0.1;zh_cn; Le X820 Build/FEXCNFN5801507014S) AppleWebKit/537.36 (KHTML, like Gecko)Version/4.0 Chrome/49.0.0.0 Mobile Safari/537.36 EUI Browser/5.8.015S'
    ]
  ],
  /**
   * 是否显示日志
   */
  'log_show' => false,
  /**
   * 日志目录, 默认在data根目录下
   */
  'log_file' => storage_path('cache' . DIRECTORY_SEPARATOR . 'spider'),
  /**
   * 显示和记录的日志类型
   * 普通类型: info
   * 警告类型: warn
   * 调试类型: debug
   * 错误类型: error
   */
  'log_type' => 'error,debug',
  /**
   * 输入编码
   * 明确指定输入的页面编码格式(UTF-8,GB2312,…..)，防止出现乱码,如果设置null则自动识别
   */
  'input_encoding' => null,
  /**
   * 输出编码
   * 明确指定输出的编码格式(UTF-8,GB2312,…..)，防止出现乱码,如果设置null则为utf-8
   */
  'output_encoding' => null,
  'export' => [
    'default' => 'db',
    'options' => [
      'db' => [
        'type' => 'db',
        'table' => 'spider_collect_contents',
      ],
      'sql' => [
        'type'  => 'sql',
        'file'  => './data/spider_.sql',
        'table' => 'spider_collect_contents',
      ],
      'csv' => [
        'type' => 'csv',
        'file' => './data/spider_.csv',
      ],
    ],
  ],
];
