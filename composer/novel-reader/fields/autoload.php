<?

use phpspider\core\requests;
use phpspider\core\selector;

class SpiderModel
{
  /**
   * 页面URL
   */
  public $__url__;
  /**
   * 页面标题
   */
  public $__title__;

  /**
   * 原始数据
   */
  public $__origin__;

  /**
   * 构造方法
   */
  function __construct($model, ...$args)
  {
    foreach ($model ?: [] as $name => $value) {
      $this->__set($name, $value);
    }
    if (method_exists($this, 'construct')) {
      $this->{'construct'}($model, ...$args);
    }
    $this->__origin__ = $model;
  }

  function __set($name, $value)
  {
    if (method_exists($this, 'set' . $this->camelize($name))) {
      $this->{'set' . $this->camelize($name)}($value);
    } else if (!property_exists($this, $name)) {
      return;
    } else {
      $this->{$name} = $value;
    }
  }
  function __get($name)
  {
    if (!isset($this->{$name})) return;
    return $this->{$name};
  }
  /**
　　* 下划线转驼峰
　　* 思路:
　　* step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
　　* step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
　　*/
  function camelize($uncamelized_words, $separator = '_')
  {
    $uncamelized_words = $separator . str_replace($separator, " ", strtolower($uncamelized_words));
    return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator);
  }

  /**
   * 驼峰命名转下划线命名
　　* 思路:
　　* 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
　　*/
  function uncamelize($camelCaps, $separator = '_')
  {
    return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
  }
  /**
   * 转为数组
   */
  function to_array()
  {
    return json_decode(json_encode($this));
  }
  /**
   * 输出HTML内容
   */
  function to_html()
  {
    echo json_encode($this);
  }
}
/** 小说数据源
 * 
 */
class NovelSourceModel extends SpiderModel
{
  public $key;
  /** 
   * 名称
   */
  public $name;
  /** 
   * 网站地址
   * 
   */
  public $url;
  /** 
   * 类名
   */
  public $class_name;
  /** 
   * 数据源类型
   * genuine 正版源
   * non_genuine 可在线阅读非正版源
   * txt_genuine 可阅读/下载非正版源
   */
  public $type;
}

class NovelListModel extends SpiderModel
{
  /**
   * 小说列表
   */
  public $list;
  function setList($list)
  {
    $this->list = array_map(function ($item) {
      return new NovelInfoModel($item);
    }, $list);
  }
}

/**
 * 小说基本信息
 */
class NovelInfoModel extends SpiderModel
{
  public $id;
  /**
   * 名称
   */
  public $name;
  /**
   * 封面
   */
  public $cover;
  /**
   * 介绍
   */
  public $intro;
  /**
   * 作者
   */
  public $author;
  /**
   * 最新章节
   */
  public $latest_chapter;
  /**
   * 下载地址
   */
  public $txt;
  function setAuthor($author)
  {
    $this->author = new NovelAuthorModel($author);
  }
  function setLatestChapter($chapter)
  {
    $this->latest_chapter = new NovelChapterModel($chapter);
  }
}
/**
 * 作者
 */
class NovelAuthorModel extends SpiderModel
{
  public $id;
  /**
   * 名称
   */
  public $name;
  /**
   * 头像
   */
  public $avater;
  /**
   * 作品
   */
  public $novels;
}
/**
 * 目录
 */
class NovelCatalogModel extends NovelInfoModel
{
  /**
   * 目录列表
   */
  public $catalog;
  function setCatalog($catalog)
  {
    $this->catalog = array_map(function ($item) {
      return new NovelChapterModel($item);
    }, $catalog);
  }
}
/**
 * 章节
 */
class NovelChapterModel extends SpiderModel
{
  public $id;
  /**
   * 标题
   */
  public $title;
  /**
   * 内容
   */
  public $content;
  /**
   * 时间
   */
  public $time;
  /**
   * 上一章
   */
  public $prev;
  /**
   * 下一章
   */
  public $next;
  /**
   * 小说
   */
  public $novel;
  function setPrev($chapter)
  {
    $this->prev = new NovelChapterModel($chapter);
  }
  function setNext($chapter)
  {
    $this->next = new NovelChapterModel($chapter);
  }
  function setNovel($novel)
  {
    $this->novel = new NovelInfoModel($novel);
  }
}

interface SpiderInterface
{
  function spider_fields($html, $fields);

  function get_list_url($info_name);
  function spider_list_fields($info_name);
  function get_list_fields($info_name);

  function get_info_url($info_id);
  function spider_info_fields($info_id);
  function get_info_fields($info_id);

  function get_catalog_url($info_id);
  function spider_catalog_fields($info_id);
  function get_catalog_fields($info_id);

  function get_chapter_url($chapter_id, $info_id);
  function spider_chapter_fields($chapter_id, $info_id);
  function get_chapter_fields($chapter_id, $info_id);
}
/** 
 * SpiderNovelController
 * - spider_list($url)
 *   - $url = static::$on_before_spider_list($url)
 *   - $html = static::$on_download_list_page($html,$url)
 * - spider_info($url)
 * - spider_catalog($url)
 * - spider_chapter($url)
 */
class SpiderController
{
  public static $list_fields = [];
  static $on_get_list_url = null;
  public static $on_download_list_page = null;
  public static $on_extract_list_item_fields = null;
  public static $on_extract_list_page = null;
  public static $on_construct_list_model = null;

  public static $info_fields = [];
  public static $on_get_info_url = null;
  public static $on_download_info_page = null;
  public static $on_extract_info_page = null;
  public static $on_construct_info_model = null;

  public static $catalog_fields = [];
  public static $on_get_catalog_url = null;
  public static $on_download_catalog_page = null;
  public static $on_extract_catalog_item_fields = null;
  public static $on_extract_catalog_page = null;
  public static $on_construct_catalog_model = null;

  public static $chapter_fields = [];
  public static $on_get_chapter_url = null;
  public static $on_download_chapter_page = null;
  public static $on_extract_chapter_page = null;
  public static $on_construct_chapter_model = null;

  function spider_fields($html, $fields = [])
  {
    $row = [];
    foreach ($fields as $field) {
      if (!isset($field['name']) || !isset($field['selector'])) {
        continue;
      }
      $name = $field['name'];
      $selector = $field['selector'];
      $row[$name] = selector::select($html, $selector);
      if (isset($field['children'])  && sizeof($field['children']) > 0) {
        if (is_array($row[$name]) && $field['repeated'] == true) {
          $row[$name] = array_map(function ($item) use ($field) {
            return $this->spider_fields($item, $field['children']);
          }, $row[$name]);
        } else {
          $row[$name] = $this->spider_fields(is_array($row[$name]) ? $row[$name][0] : $row[$name], $field['children']);
        }
      }
    }
    return $row;
  }

  function spider_page_fields($type, $url, $model_name, $item_key = null)
  {
    // 检测抽取规则是否存在
    if (!static::${"{$type}_fields"}) return false;

    // 页面地址
    if (method_exists($this, "on_get_{$type}_url")) {
      $result = $this->{"on_get_{$type}_url"}($url);
      $url = $result ?: $url;
      unset($result);
    }
    $html = requests::get($url);
    // 页面内容
    if (method_exists($this, "on_download_{$type}_page")) {
      $result =  $this->{"on_download_{$type}_page"}($html, $url);
      $html = $result ?: $html;
      unset($result);
    }
    file_put_contents(__DIR__ . "/../tmp.html", $html);
    $data = $this->spider_fields($html, static::${"{$type}_fields"});

    // 页面基本信息
    $data['__url__'] = $url;
    $data['__title__'] = selector::select($html, "//title");

    // 子规则
    if (!is_null($item_key) && method_exists($this, "on_extract_{$type}_item_fields")) {
      if (sizeof($data[$item_key]) > 0 && is_null($data[$item_key][0])) {
        $data[$item_key] = [$data[$item_key]];
      }
      $result = [];
      foreach ($data[$item_key] as $fields) {
        $fields =  $this->{"on_extract_{$type}_item_fields"}($fields, $data, $html, $url);
        $fields ? array_push($result, $fields) : null;
      }
      $data[$item_key] = $result;
      unset($result);
    }
    // 数据提取后
    if (method_exists($this, "on_extract_{$type}_page")) {
      $result =  $this->{"on_extract_{$type}_page"}($data, $html, $url);
      $data = $result ?: $data;
      unset($result);
    }
    $model = new $model_name($data);
    // 数据实例化
    if (method_exists($this, "on_construct_{$type}_model")) {
      $result =  $this->{"on_construct_{$type}_model"}($model, $data, $html, $url);
      $model = $result ?: $model;
      unset($result);
    }
    return $model;
  }
  function spider_list_fields($url)
  {
    return $this->spider_page_fields("list", $url, "NovelListModel", "list");
  }
  function spider_info_fields($url)
  {
    return $this->spider_page_fields("info", $url, "NovelInfoModel");
  }
  function spider_catalog_fields($url)
  {
    return $this->spider_page_fields("catalog", $url, "NovelCatalogModel", "catalog");
  }
  function spider_chapter_fields($url)
  {
    return $this->spider_page_fields("chapter", $url, "NovelChapterModel");
  }
}

$_NOVEL_SOURCE = [];

require_once __DIR__ . "/qidian.php";
require_once __DIR__ . "/zongheng.php";
require_once __DIR__ . "/siluwx.php";
require_once __DIR__ . "/zzs5.php";
require_once __DIR__ . "/kankezw.php";
