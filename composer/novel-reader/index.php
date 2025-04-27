<?
if (!file_exists(__DIR__ . "/.env")) {
  Header("Location: install.php");
  exit;
}
require_once __DIR__ . '/vendor/autoload.php';
// require_once __DIR__ . '/source/autoload.php';
require_once __DIR__ . "/fields/autoload.php";
// 路由地址
$route_path = substr($_SERVER['PATH_INFO'], 1);
// 小说数据源
$source = $_GET['source'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <title>Novel Reader - Langnang</title> -->
  <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap-theme.min.css"> -->
  <script src="/node_modules/jquery/dist/jquery.min.js"></script>
  <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <style>
    <? for ($i = 1; $i <= 12; $i++) : ?>.col-<? echo $i ?> {
      float: left;
      width: calc(100% / 12 * <? echo $i ?>);
      position: relative;
      min-height: 1px;
      padding-right: 15px;
      padding-left: 15px;
    }

    <? endfor ?>
  </style>
  <script>
    function toggleCollapse(e) {
      const tbody = $(e).closest('tbody');
      // console.log(tbody);
      const index = $(e).closest('tr').index() / 2;
      // console.log(index);
      $(".collapse").eq(index).collapse('toggle');
    }

    const shelf = JSON.parse(localStorage.getItem("shelf")) || {};

    function is_exist_shelf(novel_name) {
      if (!shelf[novel_name]) {

      }
    }

    function insert_shelf(novel) {
      console.log(novel);
      novel = JSON.parse(novel);
      if (!novel.name || novel.name == '') return;
      shelf[novel.name] = novel;
      localStorage.setItem("shelf", JSON.stringify(shelf));
    }
  </script>
</head>

<body>
  <div class="container">
    <? if ($route_path == 'catalog') : include_once(__DIR__ . "/views/catalog.php") ?>
    <? elseif ($route_path == 'chapter') : include_once(__DIR__ . "/views/chapter.php") ?>
    <? elseif (true) : include_once(__DIR__ . "/views/list.php") ?>
    <? endif; ?>
  </div>

</body>

</html>