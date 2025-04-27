<?php

namespace Langnang\OneCrawler;

require_once __DIR__ . '/Model.php';



use Langnang\PhpServer\Model;
use phpspider\core\requests;
use phpspider\core\selector;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem;

/**
 * 字符串前拼接
 */
function prestr($str1, $str0)
{
  return $str0 . $str1;
}
/**
 * 字符串后拼接
 */
function sufstr($str0, $str1)
{
  return $str0 . $str1;
}
class Source extends Model
{
  // 资源类型
  public $class = "source";

  public $id;
  /**
   * 源 URL
   * @var string
   */
  public $url;
  /**
   * 源名称
   * @var string
   */
  public $name;
  /**
   * 源分组
   * @var string
   */
  public $group;
  /**
   * 源注释
   * @var string
   */
  public $comment;
  public $loginUrl;
  public $loginUi;
  public $loginCheckJs;
  public $itemUrlRegex;
  public $variableComment;
  public $concurrentRate;
  public $discover;
  public $search;
  public $detail;
  public $category;
  public $content;
  public $download;
  function __self__construct($args)
  {
    $this->id = isset($args['id']) ? $args['id'] : md5(uniqid(mt_rand(), true));
  }
  function set_discover($value)
  {
    $this->discover = new SourceDiscover($value);
  }
  function set_search($value)
  {
    $this->search = new SourceSearch($value);
  }
  function set_detail($value)
  {
    $this->detail = new SourceDetail($value);
  }
  function set_category($value)
  {
    $this->category = new SourceCategory($value);
  }
  function set_content($value)
  {
    $this->content = new SourceContent($value);
  }
  function set_download($value)
  {
    $this->download = new SourceDownload($value);
  }
  function exec($args)
  {
    if (empty($args['type']) || !isset($this->{$args['type']})) {
      return;
    }
    $args['prefixUrl'] = $this->url;
    return $this->{$args['type']}->exec($args);
  }
}
class SourceItem extends Model
{
  public $url;
  private $html;
  public $parentUrl;
  public $container = "//html";
  public $item;
  public $addition;
  function set_url($value)
  {
    $this->url = $value;
  }
  function set_item($value)
  {
    if (is_array($value) && count($value) != 4) {
      $this->item = new self($value, false);
    }
  }
  function is_preg($regex)
  {
    return preg_match("/^\/.+\/[a-z]*$/i", $regex);
  }
  function _filter($value, $exp)
  {
    $funcExpArray = preg_split("/(\(|\)|,)/", $exp);
    $last = array_pop($funcExpArray);
    $funcName = $funcExpArray[0];
    if (function_exists($funcName)) {
      if (in_array($funcName, ['explode'])) {
        $value = call_user_func($funcName, $funcExpArray[1], $value, ...array_slice($funcExpArray, 2));
      } else {
        $value = call_user_func($funcName, $value, ...array_slice($funcExpArray, 1));
      }
    } else {
      switch ($funcExpArray[0]) {
          // 字符串前拼接
        case "prestr":
          $value = implode("", array_merge(array_slice($funcExpArray, 1), [$value]));
          break;
          // 字符串后拼接
        case "sufstr":
          $value = implode("", array_merge([$value], array_slice($funcExpArray, 1)));
          break;
        default:
          break;
      }
    }
    if ($last && $last[0] == '[' && $last[strlen($last) - 1] == ']') {
      $key = substr($last, 1, -1);
      $value = $value[$key];
    }
    return $value;
  }
  function _crawler($html, $xpath)
  {
    $result = [];
    $xpathList = explode("\n", $xpath);
    foreach ($xpathList as $x) {
      $xpath_group = explode("::", $x);
      $value = (array)selector::select($html, $xpath_group[0]);
      if ($xpath_group[1]) {
        $value = array_map(function ($item) use ($xpath_group) {
          foreach (explode("|", $xpath_group[1]) as $func) {
            $item = $this->_filter($item, $func);
          }
          return $item;
        }, $value);
      }
      $result = array_merge($result, $value);
    }
    return $result;
  }
  /**
   * @param html 
   * @param ignoreKeys 
   */
  function crawler($html,  $ignoreKeys = [])
  {
    $result = [];
    $list = $this->_crawler($html, $this->container);
    $vars = array_filter(array_keys((array)$this), function ($name) use ($ignoreKeys) {
      if (in_array($name, array_merge(['container', 'item', 'html'], $ignoreKeys))) return false;
      if (empty($this->{$name})) return false;
      return true;
    });
    foreach ($list as $index => $container) {
      array_push($result, array_reduce($vars, function ($total, $name) use ($html, $container, $index) {
        if (!in_array(substr($this->{$name}, 0, 2), ['//', '(/'])) {
          $value = (array)$this->_crawler($html, $this->container . $this->{$name})[$index];
        } else {
          $value = $this->_crawler($container, $this->{$name});
        }
        // $xpath = explode("::", $this->{$name})[0];
        // if (explode("::", $this->{$name})[1]) {
        //   $value = array_map(function ($item) use ($name) {
        //     foreach (explode("|", explode("::", $this->{$name})[1]) as $func) {
        //       $item = $this->_filter($item, $func);
        //     }
        //     return $item;
        //   }, $value);
        // }
        if (sizeof($value) <= 1) $value = $value[0];
        $total[$name] = $value;
        return $total;
      }, []));
    }
    return $result;
  }

  function get_html($url, ...$args)
  {
    $path = md5($url);
    $adapter = new LocalFilesystemAdapter(__DIR__ . '/../cache/');
    $filesystem = new Filesystem($adapter);
    if ($filesystem->fileExists($path)) {
      // TODO 更新时间：相同页面请求间隔
      // $lastModified = $filesystem->lastModified($path);
      return $filesystem->read($path);
    } else {
      $html = requests::get($url, ...$args);
      $filesystem->write($path, $html);
      return $html;
    }
  }
}


class SourceDiscover extends SourceItem
{
  /**
   * 总数
   */
  public $total;
  /**
   * 页数
   */
  public $pages;
  /**
   * 页码
   */
  public $page;
  function get_url($args = [])
  {
    $urlGroup = [];
    foreach (explode("\n", $this->url) as $item) {
      $name_group = array_map(function ($item) {
        return $item['name'];
      }, $urlGroup);
      $url_exp_array = explode("::", $item);
      $name = $url_exp_array[0];
      $url = $url_exp_array[1];
      // if (isset($args['page']) && strpos($url, "{{page}}")) {
      //   $url = str_replace("{{page}}", $args['page'], $url);
      //   var_dump($url);
      // }
      $index = array_search($name, $name_group);
      $item = [
        'name' => $name,
        'url' => $url,
      ];
      if ($index === false) {
        array_push($urlGroup, [
          'name' => $name,
          'urls' => [$url],
        ]);
      } else {
        array_push($urlGroup[$index]['urls'], $url);
      }
    }
    // 遍历检索需要替换参数的 URL，并替换对应参数
    $urlGroup = array_map(function ($item) use ($args) {
      if (count($item['urls']) == 1) {
        $item['url'] = $item['urls'][0];
      } else {
        $url = array_reduce($item['urls'], function ($t, $v) {
          if (strpos($v, "{{page}}")) return $v;
          return $t;
        }, false);
        if ($url && isset($args['page'])) {
          $item['url'] = $url;
        } else {
          $item['url'] = $item['urls'][0];
        }
      }
      $item['url'] = str_replace("{{page}}", isset($args['page']) ? $args['page'] : 1, $item['url']);
      return $item;
    }, $urlGroup);
    if (isset($args['index'])) {
      return $urlGroup[$args['index']]['url'];
    }
    return $urlGroup;
  }
  function exec($args)
  {
    if (!$this->url) return;
    $url = $args['prefixUrl'] . $this->get_url($args);
    $html = $this->get_html($url);
    if (!$html) return;
    $result = [];
    foreach (['total', 'pages', 'page'] as $key) {
      if (!$this->{$key}) continue;
      $result[$key] = $this->_crawler($html, $this->{$key});
      if (count($result[$key]) === 1) $result[$key] = $result[$key][0];
    }
    if ($this->container) {
      $container = $this->_crawler($html, $this->container);
      $result['item'] = array_reduce($container, function ($t, $item) {
        return array_merge($t, $this->item->crawler($item));
      }, []);
    }

    return $result;
  }
}
class SourceSearch extends SourceItem
{
  /**
   * 总数
   */
  public $total;
  /**
   * 页数
   */
  public $pages;
  /**
   * 页码
   */
  public $page;
  function exec($args)
  {
    if (!$this->url) return;
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
    if (!$html) return;
    $result = [];
    foreach (['total', 'pages', 'page'] as $key) {
      if (!$this->{$key}) continue;
      $result[$key] = $this->_crawler($html, $this->{$key});
      if (count($result[$key]) === 1) $result[$key] = $result[$key][0];
    }
    if ($this->container) {
      $container = $this->_crawler($html, $this->container);
      $result['item'] = array_reduce($container, function ($t, $item) {
        return array_merge($t, $this->item->crawler($item));
      }, []);
    }

    return $result;
  }
}
class SourceDetail extends SourceItem
{
  public $urlRegex;
  function exec($args)
  {
    if (!$this->urlRegex) return;
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
    return $result;
  }
}
class SourceCategory extends SourceItem
{
  public $group;
  public $urlRegex;
  function exec($args)
  {
    if (!$this->urlRegex) return;
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
    if ($this->group) {
      $result['group'] = $this->_crawler($html, $this->group);
    }
    $result['category'] = array_map(function ($item) {
      return $this->item->crawler($item);
    }, $container);
    return $result;
  }
}

class SourceContent extends SourceItem
{
  public $urlRegex;
  function exec($args)
  {
    if (!$this->urlRegex) return;
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


class SourceDownload extends SourceItem
{
  public $parentUrl;
  public $urlRegex;
  function exec($args)
  {
    if (!$this->urlRegex) return;
    $result = [];
    $uri = parse_url($args['uri'])['path'];
    if (!preg_match($this->urlRegex, $uri)) {
      return;
    }
    $result['url'] = $args['prefixUrl'] . $uri;
    $html = $this->get_html($result['url']);
    $container = $this->_crawler($html, $this->container);
    $result = array_reduce($container, function ($t, $item) {
      return array_merge($t, $this->item->crawler($item));
    }, []);
    return $result;
  }
}
