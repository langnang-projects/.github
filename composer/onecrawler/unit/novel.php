<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../source/Novel.php';

$option = json_decode(file_get_contents(__DIR__ . "/novel.json"), true);

$novel = new Langnang\OneCrawler\Source\Novel($option);
$list = $novel->exec($_GET);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title> Static Bootstrap v3 </title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" /> -->
  <style>
    .source-item_content *:not(p) {
      display: none;
    }
  </style>
</head>

<body>

  <div id="app" class="container-fluid" style="padding-left: 0;padding-right: 0;">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Brand</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <?php foreach ($novel->discover->get_url() as $index => $type) : ?>
              <li><a href="?type=discover&index=<?php echo $index ?>"><?php echo $type['name'] ?></a></li>
            <?php endforeach; ?>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Link</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </li>
          </ul>
          <form class="navbar-form navbar-right" action="">
            <span class="input-group" style="display: none;">
              <input type="text" class="form-control" placeholder="Search" name="type" value="search">
            </span>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search" name="key">
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit">
                  <i class="glyphicon glyphicon-search"></i>
                </button>
              </span>
            </div>
          </form>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <div class="container">
      <? if ($_GET['type'] == 'chapter') : ?>
        <?php foreach ($list as $item) : ?>
          <h3 class="text-center"><? echo $item['name'] ?></h3>
          <hr>
          <div class="source-item_content">
            <? echo $item['content'] ?>
          </div>
        <?php endforeach; ?>
      <? endif ?>
      <div class="row">
        <ul class="list-group">
          <? if ($_GET['type'] == 'search' || $_GET['type'] == 'discover') : ?>
            <?php foreach ($list as $item) : ?>
              <a class="list-group-item col-md-12" href="?type=category&uri=<? echo $item['url'] ?>">
                <div class="col-md-1">
                  <? if (!empty($item['cover'])) : ?>
                    <img src="<? echo $item['cover'] ?>" alt="" style="width: 100%;">
                  <? endif ?>
                </div>
                <div class="col-md-6">
                  <h4> <? echo implode('', (array)$item['name'])  ?></h4>
                </div>
              </a>
            <?php endforeach; ?>
          <? elseif ($_GET['type'] == 'category') : ?>
            <?php foreach ($list as $item) : ?>
              <a class="list-group-item col-md-3" href="?type=chapter&uri=<? echo $item['url'] ?>" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="<? echo $item['name'] ?>">
                <? echo $item['name'] ?>
              </a>
            <?php endforeach; ?>
          <? endif ?>
        </ul>
      </div>
    </div>
    <script src="https://fastly.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>

<?
// var_dump($list);
