<?php

namespace Langnang\OneCrawler\Source;

require_once __DIR__ . '/../app/Source.php';

use Langnang\PhpServer\App;
use Langnang\OneCrawler\Source;
use Langnang\OneCrawler\SourceItem;

class Novel extends Source
{
  public $_tag = "novel";
  /**
   * 小说发现
   * @var NovelDiscover
   */
  public $discover;
  /**
   * 小说搜索
   * @var NovelSearch
   */
  public $search;
  /**
   * 小说详情
   * @var NovelDetail
   */
  public $detail;
  /**
   * 小说章节目录
   * @var NovelCategory
   */
  public $category;
  /**
   * 小说章节
   */
  public $content;
  function set_discover($value)
  {
    $this->discover = new NovelDiscover($value);
  }
  function set_search($value)
  {
    $this->search = new NovelSearch($value);
  }
  function set_detail($value)
  {
    $this->detail = new NovelDetail($value);
  }
  function set_category($value)
  {
    $this->category = new NovelCategory($value);
  }
  function set_content($value)
  {
    $this->content = new NovelContent($value);
  }
  function exec($args)
  {
    if (empty($args['type']) || !isset($this->{$args['type']})) {
      return;
    }
    $args['prefixUrl'] = $this->url;
    return $this->{$args['type']}->exec($args);
  }

  // static function select
}
class NovelItem extends SourceItem
{
  function set_item($value)
  {
    $this->item = new self($value, false);
  }
}
class NovelDiscover extends NovelItem
{
  function get_url($args = [])
  {
    $urlGroup = array_reduce(explode("\n", $this->url), function ($t, $item) {
      if (empty(trim($item))) return $t;
      $item = explode("::", $item);
      array_push($t, array(
        "name" => $item[0],
        "url" => $item[1],
      ));
      return $t;
    }, []);
    if (isset($args['index'])) {
      $url = $urlGroup[$args['index']]['url'];
      foreach ($args as $key => $value) {
        $url = str_ireplace("{{$key}}", $value, $url);
      }
      return $url;
    }
    return $urlGroup;
  }
  function exec($args)
  {
    $url = $args['prefixUrl'] . $this->get_url($args);
    $html = $this->get_html($url);
    $container = $this->_crawler($html, $this->container);
    return array_reduce($container, function ($t, $item) {
      return array_merge($t, $this->item->crawler($item));
    }, []);
  }
}
class NovelSearch extends NovelItem
{
  function exec($args)
  {
    $uri_array = explode("::", $this->url);
    $uri = $uri_array[0];
    $args = array_merge($args, json_decode(empty($uri_array[1]) ? "[]" : $uri_array[1], true));
    $prefixUrl = $args['prefixUrl'];
    if (substr($uri, 0, strlen($prefixUrl)) == $prefixUrl) {
      $uri = substr($uri, strlen($prefixUrl));
    }
    $url = $prefixUrl . $uri;
    $key = $args['key'];
    if ($args['charset']) {
      $key = iconv('utf-8', $args['charset'], $key);
    }
    $key = urlencode($key);
    $url = str_ireplace("{{key}}", $key, $url);

    $html = $this->get_html($url);
    $container = $this->_crawler($html, $this->container);
    return array_reduce($container, function ($t, $item) {
      return array_merge($t, $this->item->crawler($item));
    }, []);
  }
}
class NovelDetail extends NovelItem
{
  public $urlRegex;
  function exec($args)
  {
    $result = [];
    $uri = parse_url($args['uri'])['path'];
    if (!preg_match($this->urlRegex, $uri)) {
      return;
    }
    $this->url = $args['prefixUrl'] . $uri;
    $html = $this->get_html($this->url);
    $container = $this->_crawler($html, $this->container);
    $result = array_reduce($container, function ($t, $item) {
      return array_merge($t, $this->item->crawler($item));
    }, []);
    $result = array_map(function ($item) use ($args) {
      if (!parse_url($item['cover'])['host']) {
        if ($item['cover']) $item['cover'] = $args['prefixUrl'] . parse_url($item['cover'])['path'];
      }
      return $item;
    }, $result);
    return $result;
  }
}
class NovelCategory extends NovelItem
{
  public $urlRegex;
  function exec($args)
  {
    $result = [];
    $uri = parse_url($args['uri'])['path'];
    if (!preg_match($this->urlRegex, $uri)) {
      return;
    }
    $this->url = $args['prefixUrl'] . $uri;
    $html = $this->get_html($this->url);
    foreach (['parentUrl'] as $key) {
      if ($this->{$key}) $result[$key] = $this->_crawler($html, $this->{$key});
    }
    $container = $this->_crawler($html, $this->container);

    $result['category'] = array_reduce($container, function ($t, $item) {
      return array_merge($t, $this->item->crawler($item));
    }, []);
    return $result;
  }
}

class NovelContent extends NovelItem
{
  public $urlRegex;
  function exec($args)
  {
    $result = [];
    $uri = parse_url($args['uri'])['path'];
    if (!preg_match($this->urlRegex, $uri)) {
      return;
    }
    $this->url = $args['prefixUrl'] . $uri;
    $html = $this->get_html($this->url);
    foreach (['parentUrl'] as $key) {
      if ($this->{$key}) $result[$key] = $this->_crawler($html, $this->{$key});
    }
    $container = $this->_crawler($html, $this->container);
    $result['item'] = array_reduce($container, function ($t, $item) {
      return array_merge($t, $this->item->crawler($item));
    }, []);
    return $result;
  }
}


App::addSource([
  "key" => "novel",
  "name" => "小说",
  "class" => "Langnang\OneCrawler\Source\Novel",
  "exec" => [
    "discover" => "index",
    "search" => "key",
    "detail" => "uri",
    "category" => "uri",
    "content" => "uri",
  ],
  "categoryParams" => [],
  "contentParams" => []
]);
