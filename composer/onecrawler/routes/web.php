<?php

use Langnang\PhpServer\App;

/**
 * admin
 */
App::render_view('/login', '/admin/login.php');

App::response('GET', '/', function ($vars, $app) {
  echo $app->twig->render('/index.php', [
    'app' => $app,
    'vars' => $vars,
  ]);
});

App::response('GET', '/admin', function ($vars, $app) {
  echo $app->twig->render('/admin/index.php', [
    'app' => $app,
    'vars' => $vars,
  ]);
});

// TODO 控制页面按钮显示
App::response('GET', '/{class}', function ($vars, $app) {
  $nav = $app->getSource($vars['class']);
  echo $app->twig->render("/source/subscribe.php", [
    'app' => $app,
    'vars' => $vars,
    'nav' => $nav,
    'breadcrumb' => [['name' => "订阅"]]
  ]);
});
App::response('GET', '/{class}/source', function ($vars, $app) {
  $nav = $app->getSource($vars['class']);
  $sources = $app->select_source($vars['class']);
  echo $app->twig->render("/source/source_list.php", [
    'app' => $app,
    'vars' => $vars,
    'nav' => $nav,
    'list' => $sources,
    'breadcrumb' => [['name' => "资源"]]
  ]);
});

App::response('GET', '/{class}/source/{id}', function ($vars, $app) {
  $nav = $app->getSource($vars['class']);
  $source = $app->select_source($vars['class'], $vars['id']);
  echo $app->twig->render("/source/source_item.php", [
    'app' => $app,
    'vars' => $vars,
    'nav' => $nav,
    'item' => (array)$source,
    'breadcrumb' => [
      ['name' => "资源"],
      $vars['id'] == 'insert' ? ['name' => '新增'] : ['name' => $source->name]
    ]
  ]);
});

App::response('GET', '/{class}/discover', function ($vars, $app) {
  $nav = $app->getSource($vars['class']);
  $sources = $app->select_source($vars['class']);
  $sources = array_map(function ($item) {
    $item->discover->urlGroup = $item->discover->get_url();
    return $item;
  }, $sources);
  echo $app->twig->render("/source/discover_list.php", [
    'app' => $app,
    'vars' => $vars,
    'nav' => $nav,
    'sources' => $sources,
    'breadcrumb' => [
      ['name' => "发现"],
    ]
  ]);
});

App::response('GET', '/{class}/discover/{id}/{index}', function ($vars, $app) {
  $vars['type'] = "discover";
  $nav = $app->getSource($vars['class']);
  $source = ($app->select_source($vars['class'], $vars['id']));
  $discover = $source->exec($vars);
  $urls = $source->discover->get_url();
  foreach ($urls as $index => $item) {
    $urls[$index]['href'] = "discover/{$source->id}/{$index}";
  }
  echo $app->twig->render("/source/discover_item.php", [
    'app' => $app,
    'vars' => $vars,
    'nav' => $nav,
    'source' => (array)$source,
    'discover' => $discover,
    'breadcrumb' => [
      ['name' => "发现"],
      ['name' => $source->name],
      [
        'name' => $urls[$vars['index']]['name'],
        'options' => $urls,
      ]

    ]
  ]);
});

App::response('GET', '/{class}/detail/{id}', function ($vars, $app) {
  $nav = $app->getSource($vars['class']);
  $source = ($app->select_source($vars['class'], $vars['id']));
  $uri = parse_url($vars['uri'])['path'];
  if ($source->detail->urlRegex == $source->category->urlRegex) {
    $detail = $source->exec(['type' => 'detail', "uri" => $uri])[0];
    $category = $source->exec(['type' => 'category', "uri" => $uri]);
  } else
  if (preg_match($source->detail->urlRegex, $uri)) {
    $detail = $source->exec(['type' => 'detail', "uri" => $uri])[0];
    $category = $source->exec(['type' => 'category', "uri" => $detail['category']]);
  } else
  if (preg_match($source->category->urlRegex, $uri)) {
    $category = $source->exec(['type' => 'category', "uri" => $uri]);
    $detail = $source->exec(['type' => 'detail', "uri" => $category['parentUrl'][0]])[0];
  }
  if ($source->download->urlRegex) {
    if ($source->download->urlRegex == $source->detail->urlRegex) {
      $download = $source->exec(['type' => 'download', "uri" => $uri])[0];
    } else if ($detail['download']) {
      $download = $source->exec(['type' => 'download', "uri" => $detail['download']])[0];
    }
  }
  echo $app->twig->render("/source/detail.php", [
    'app' => $app,
    'vars' => $vars,
    'nav' => $nav,
    'source' => (array)$source,
    'detail' => $detail,
    'category' => $category,
    'download' => $download,
    'breadcrumb' => [
      isset($source) ? ['name' => $source->name] : ['name' => "发现"],
      isset($detail) ? ['name' => $detail['name']] : null
    ]
  ]);
});

App::response('GET', "/{class}/content/{id}", function ($vars, $app) {
  $nav = $app->getSource($vars['class']);
  $source = ($app->select_source($vars['class'], $vars['id']));
  $uri = parse_url($vars['uri'])['path'];
  $content = $source->exec(['type' => 'content', "uri" => $uri]);
  $detail = $source->exec(['type' => 'detail', "uri" => $content['parentUrl'][0]])[0];
  if ($source->detail->urlRegex == $source->category->urlRegex) {
    $detail['category'] = $content['parentUrl'][0];
  }
  echo $app->twig->render("/source/content.php", [
    'app' => $app,
    'vars' => $vars,
    'nav' => $nav,
    'source' => (array)$source,
    'detail' => $detail,
    'content' => $content['item'][0],
    'breadcrumb' => [
      ['name' => $source->name],
      ['name' => $detail['name'], 'href' => "/{$vars['class']}/detail/{$source->id}?uri={$detail['category']}"],
      ['name' => $content['item'][0]['name']]
    ]
  ]);
});

App::response('GET', '/{class}/search', function ($vars, $app) {
  $result = [];
  $nav = $app->getSource($vars['class']);
  $sources = $app->select_source($vars['class']);
  if ($vars['key']) {
    foreach ($sources as $index => $source) {
      $list = $source->exec(['type' => 'search', 'key' => $vars['key']])['item'];
      foreach ((array)$list as $item) {
        $item['source_index'] = $index;
        $item['source'] = $source;
        $item['name'] = is_array($item['name']) ? implode('', $item['name']) : $item['name'];
        $item['author'] = is_array($item['author']) ? implode('', $item['author']) : $item['author'];
        $_key = $item['name'] . "::" . $item['author'];
        if (!$result[$_key]) $result[$_key] = [];
        array_push($result[$_key], $item);
      }
    }
  }


  echo $app->twig->render('/source/search.php', [
    'app' => $app,
    'vars' => $vars,
    'nav' => $nav,
    'list' => $result,
    'breadcrumb' => [
      ['name' => "搜索"],
      $vars['key'] ? ['name' => $vars['key']] : null,
    ]
  ]);
});

App::response('GET', '/{class}/export', function ($vars, $app) {
  echo json_encode($app->select_source($vars['class']), JSON_UNESCAPED_UNICODE);
});
