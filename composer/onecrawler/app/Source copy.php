<?php

namespace Langnang\OneCrawler;

require_once __DIR__ . '/Model.php';

use Langnang\PhpServer\Model;
use phpspider\core\requests;
use phpspider\core\selector;

class SourceFn extends Model
{
  function set_item($value)
  {
    $this->item = new SourceItem($value);
  }
  function __select($html, $xpath)
  {
    return array_reduce(explode("\n", $xpath), function ($t, $x) use ($html) {
      return array_merge($t, (array)selector::select($html, $x));
    }, []);
  }
}

class Source extends SourceFn
{
  protected $_tag = "source";
  /**
   * 源 URL
   * @var string
   */
  public $sourceUrl;
  /**
   * 源名称
   * @var string
   */
  public $sourceName;
  /**
   * 源分组
   * @var string
   */
  public $sourceGroup;
  /**
   * 源注释
   * @var string
   */
  public $sourceComment;
  public $loginUrl;
  public $loginUi;
  public $loginCheckJs;
  public $itemUrlRegex;
  public $variableComment;
  public $concurrentRate;
  /**
   * 正则
   */
  public $itemRegex;
  public $ruleSearch;
  public $ruleFind;
  public $ruleDetail;
  public $ruleCategory;
  public $ruleContent;
  function set_ruleFind($value)
  {
    $this->ruleFind = new SourceItemFind($value);
  }

  function find($index = 0)
  {
    return $this->ruleFind->select($index, $this->sourceUrl);
  }
  function set_ruleSearch($value)
  {
    $this->ruleSearch = new SourceItemSearch($value);
  }
  function search($key = "")
  {
    if (empty($key)) return;
    return $this->ruleSearch->select($key, $this->sourceUrl);
  }
  function set_ruleCategory($value)
  {
    $this->ruleCategory = new SourceItemCategory($value);
  }
  function category($uri = "")
  {
    if (empty($uri)) return;
    return $this->ruleCategory->select($uri, $this->sourceUrl);
  }
  function set_ruleContent($value)
  {
    $this->ruleContent = new SourceItemContent($value);
  }
  function content($uri = "")
  {
    if (empty($uri)) return;
    return $this->ruleContent->select($uri, $this->sourceUrl);
  }
}
class SourceItem extends SourceFn
{
  public $container;
  public $url;
  public $name;
  public $author;
  public $kind;
  public $count;
  public $latest;
  public $intro;
  /**
   * 封面 URL
   * @var string
   */
  public $cover;
  public $detail;
  /**
   * 下载 URL
   * @var string
   */
  public $download;
  /**
   * 状态
   * @var string
   */
  public $status;
  /**
   * 内容
   * @var string
   */
  public $content;
  function select($html)
  {
    $result = [];
    $list = $this->__select($html, $this->container);
    $vars = array_filter(array_keys(get_class_vars(static::class)), function ($name) {
      if ($name == 'container') return false;
      if (empty($this->{$name})) return false;
      return true;
    });
    foreach ($list as $container) {
      array_push($result, array_reduce($vars, function ($total, $name) use ($container) {
        $total[$name] = $this->__select($container, $this->{$name})[0];
        return $total;
      }, []));
    }
    return $result;
  }
}
class SourceItemSearch extends SourceFn
{
  public $url;
  public $checkKeyWord;
  public $container;
  public $item;

  function select($key, $urlPrefix = "")
  {
    $url = $urlPrefix . $this->url;
    $url = str_ireplace("{{key}}", iconv('utf-8', 'gbk', $key), $url);
    $html = requests::get($url);
    $container = $this->__select($html, $this->container);
    return array_reduce($container, function ($t, $item) {
      return array_merge($t, $this->item->select($item));
    }, []);
  }
}
class SourceItemFind extends SourceFn
{
  public $url;
  public $container;
  private $containerList = [];
  public $item;
  function get_url()
  {
    return array_reduce(explode("\n", $this->url), function ($t, $item) {
      if (empty(trim($item))) return $t;
      $item = explode("::", $item);
      array_push($t, array(
        "name" => $item[0],
        "url" => $item[1],
      ));
      return $t;
    }, []);
  }
  function select($index,  $urlPrefix = '', $page = 1)
  {
    $url = $urlPrefix . $this->get_url()[$index]['url'];
    $url = str_ireplace("{{page}}", $page, $url);
    $html = requests::get($url);
    $container = $this->__select($html, $this->container);
    return array_reduce($container, function ($t, $item) {
      return array_merge($t, $this->item->select($item));
    }, []);
  }
}
class SourceItemDetail extends SourceFn
{
  public $init;
  public $item;
}

class SourceItemCategory extends SourceFn
{
  public $urlRegex;
  public $container;
  public $item;
  function select($uri,  $urlPrefix = '')
  {
    if (preg_match($this->urlRegex, substr($uri, strlen($urlPrefix)))) {
      $uri = substr($uri, strlen($urlPrefix));
    } else if (!preg_match($this->urlRegex, $uri)) {
      return;
    }
    $url = $urlPrefix . $uri;
    $html = requests::get($url);
    $container = $this->__select($html, $this->container);
    return array_reduce($container, function ($t, $item) {
      return array_merge($t, $this->item->select($item));
    }, []);
  }
}
class SourceItemContent extends SourceFn
{
  public $urlRegex;
  public $container;
  public $item;
  function select($uri,  $urlPrefix = '')
  {
    if (preg_match($this->urlRegex, substr($uri, strlen($urlPrefix)))) {
      $uri = substr($uri, strlen($urlPrefix));
    } else if (!preg_match($this->urlRegex, $uri)) {
      return;
    }
    $url = $urlPrefix . $uri;
    $html = requests::get($url);
    $container = $this->__select($html, $this->container);
    return array_reduce($container, function ($t, $item) {
      return array_merge($t, $this->item->select($item));
    }, []);
  }
}
