<?

$source = $_GET['source'];
$source = current(array_filter($_NOVEL_SOURCE, function ($item) use ($source) {
  return $item['key'] == $source;
}));
$info_id = $_GET['novel'];
$order = $_GET['order'] ?: 'desc';
$spider = new $source['class']();
$info = $spider->spider_info_fields($info_id);
$catalog = $spider->spider_catalog_fields($info_id);
?>
<style>
  a.list-group-item {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
</style>
<title><? echo $info->name ?> | Novel Reader - Langnang</title>
<div class="row thumbnail">
  <div class="col-md-10 caption">
    <h3><? echo $info->name ?></h3>
    <p>作者：<? echo $info->author->name ?></p>
    <p><? echo $info->latest_chapter->title ?></p>
    <p><? echo $info->intro ?></p>
  </div>
</div>
<nav aria-label="...">
  <ul class="pager">
    <li><a href="/">书架</a></li>
    <li><a href=" /catalog?source=<? echo $source['key'] ?>&novel=<? echo $info_id ?>&order=<? echo $order === 'asc' ? 'desc' : 'asc' ?>"><? echo $order === 'asc' ? 'DESC' : 'ASC' ?></a></li>
    <li><a href="#" type="button" class="btn" onclick='insert_shelf("{\"name\":\"<? echo $info->name ?>\",\"source\":\"<? echo $source["key"] ?>\",\"cover\":\"<? echo $info->cover ?>\",\"id\":\"<? echo $info->id ?>\",\"chapter\":\"\"}")'><i class="glyphicon glyphicon-plus"></i>加入书架</a></li>
    <? if ($info->txt) : ?>
      <li><a href="<? echo $info->txt ?>">下载</a></li>
    <? endif ?>
  </ul>
</nav>
<div class="row">
  <div class="list-group">
    <? foreach ($order === 'asc' ? ($catalog->catalog ?: []) : array_reverse($catalog->catalog ?: []) as $row) : ?>
      <a href="/chapter?source=<? echo $source['key'] ?>&novel=<? echo $info_id ?>&chapter=<? echo $row->id ?>" class="list-group-item col-md-4">
        <? echo $row->title ?>
      </a>
    <? endforeach ?>
  </div>
</div>