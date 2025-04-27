<?php

use Langnang\OneCrawler\Source;
use Langnang\PhpServer\App;


App::response('GET', '/users', 'get_all_users_handler');
// {id} must be a number (\d+)
App::response('GET', '/user/{id:\d+}', 'get_user_handler');
// The /{title} suffix is optional
App::response('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');

/**
 * Source
 */
App::response('POST', '/api/{class}/source/test', function ($vars, $app) {
  $nav = $app->getSource($vars['class']);
  $source = new Source($vars);
  $result = [
    "source" => $source,
  ];
  if (!is_null($vars['test']['discover'])) {
    $result['discover'] = $source->exec([
      'type' => 'discover',
      'index' => $vars['test']['discover'],
      'page' =>  $vars['page']
    ]);
  }
  if (!empty($vars['test']['search'])) {
    $result['search'] = $source->exec(['type' => 'search', 'key' => $vars['test']['search']]);
  }
  if (!empty($vars['test']['detail'])) {
    $result['detail'] = $source->exec(['type' => 'detail', 'uri' => $vars['test']['detail']]);
  }
  if (!empty($vars['test']['category'])) {
    $result['category'] = $source->exec(['type' => 'category', 'uri' => $vars['test']['category']]);
  }
  if (!empty($vars['test']['content'])) {
    $result['content'] = $source->exec(['type' => 'content', 'uri' => $vars['test']['content']]);
  }
  if (!empty($vars['test']['download'])) {
    $result['download'] = $source->exec(['type' => 'download', 'uri' => $vars['test']['download']]);
  }
  return $result;
});
App::response('POST', '/api/{class}/source/insert', function ($vars, $app) {
  return $app->insert_source($vars);
});
App::response('POST', '/api/{class}/source/delete', function ($vars, $app) {
  if (!isset($vars['ids'])) return;
  return $app->delete_source($vars, $vars['ids']);
});
App::response('POST', '/api/{class}/source/update', function ($vars, $app) {
  if (!isset($vars['id'])) return;
  return $app->update_source($vars);
});
App::response('POST', '/api/{class}/source/select', function ($vars, $app) {
  return $app->select_source($vars);
});

App::response('POST', '/api/{class}/descover', function ($vars, $app) {
});
App::response('POST', '/api/{class}/search', function ($vars, $app) {
});
// TODO 更新订阅最新信息
App::response('POST', '/api/{class}/detail', function ($vars, $app) {
  $sources = array_map(function ($item) use ($vars, $app) {
    return $app->select_source($vars['class'], $item['source']);
  }, (array)$vars['list']);
});
App::response('POST', '/api/{class}/category', function ($vars, $app) {
  $list = array_map(function ($item) use ($vars, $app) {
    $source = $app->select_source($vars['class'], $item['source']);
    $category = $source->exec(['type' => 'category', 'uri' => $item['category']]);
    return array_reduce($category['category'], function ($total, $item) {
      return array_merge($total, $item);
    }, []);
  }, (array)$vars['list']);
  return $list;
});
App::response('POST', '/api/{class}/content', function ($vars, $app) {
});

App::response('POST', '/api/{class}/import', function ($vars, $app) {
  var_dump($_FILES);
});
