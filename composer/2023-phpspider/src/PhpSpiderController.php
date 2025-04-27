<?php

namespace Langnang;

use phpspider\core\phpspider as owner888PhpSpider;

class PhpSpiderController extends owner888PhpSpider
{
  public static $collect_scan_urls = array();
  public static $collect_scan_urls_num = 0;
  public static $collected_scan_urls_num = 0;
  public static $collect_list_urls = array();
  public static $collect_list_urls_num = 0;
  public static $collected_list_urls_num = 0;
  public static $collect_content_urls = array();
  public static $collect_content_urls_num = 0;
  public static $collected_content_urls_num = 0;

  /**
   * 启动服务前
   */
  public $on_before_start = null;
  /**
   * 终止服务后
   */
  public $on_before_stop = null;
  /**
   * 获取到URL为入口页
   */
  public $on_fetch_scan_url = null;
  /**
   * 获取到URL为列表页
   */
  public $on_fetch_list_url = null;
  /**
   * 获取到URL为内容页
   */
  public $on_fetch_content_url = null;

  /**
   * 新建配置表
   */
  public function create_config_table()
  {
    $sql = "CREATE TABLE `develop`.`Untitled`  (
      `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
      `key` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '',
      `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '',
      `keywords` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '',
      `domains` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '',
      `scan_urls` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '',
      `list_url_regexes` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '',
      `content_url_regexes` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '',
      `fields` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '',
      `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '类型',
      `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '状态',
      `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
      `update_time` datetime NULL DEFAULT NULL COMMENT '更新时间',
      PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 243 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;";
  }
  /**
   * 创建抽取规则对应的数据表
   */
  public function create_fields_table()
  {
  }
}
