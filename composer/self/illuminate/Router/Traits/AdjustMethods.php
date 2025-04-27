<?php

namespace Illuminate\Router\Traits;


/**
 * 矫正URI
 */
trait AdjustMethods
{
  /**
   * 以`/`开头，不以`/`结尾
   */
  function adjust_uri($uri)
  {
    // 替换全部空格
    $uri = preg_replace('/ /', '', $uri);

    $uri = rtrim($uri, '/');
    // if (Str::endsWith($uri, '/')) $uri = substr($uri, 0, -1);

    if (!\Str::startsWith($uri, "/")) $uri = '/' . $uri;

    if (!empty($this->prefix)) {
      $uri = $this->prefix .  $uri;
      $uri = rtrim($uri, '/');
    }
    // 去除?及后面内容
    $uri = preg_replace('/\?.*$/', '', $uri);

    if (preg_match_all("/{([\w\.-]+)}/", $uri, $params)) {
      // dump([$uri, preg_match_all("/{(\w+)}/", $uri, $params)]);
      // dump([$params]);
      $pattern = '';
      $pattern = str_replace($params[0], array_fill(0, count($params[0]), "([\w\.-]+)"), $uri);
    }
    return [
      'uri' => $uri,
      'pattern' => isset($pattern) ? $pattern : null,
      'params' => $params[1],
      'query' => []
    ];
  }
}
