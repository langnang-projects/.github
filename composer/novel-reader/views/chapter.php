<?

$source = $_GET['source'];
$source = current(array_filter($_NOVEL_SOURCE, function ($item) use ($source) {
  return $item['key'] == $source;
}));
$info_id = $_GET['novel'];
$chapter_id = $_GET['chapter'];
$spider = new $source['class']();
$info = $spider->spider_info_fields($info_id);
$chapter = $spider->spider_chapter_fields($info_id . '/' . $chapter_id);
?>
<title><? echo $chapter->title ?> | <? echo $info->name ?> | Novel Reader - Langnang</title>
<div class="row thumbnail">
  <div class="col-md-10 caption">
    <h3><? echo $info->name ?></h3>
    <p>作者：<? echo $info->author->name ?></p>
    <p><? echo $info->latest_chapter->title ?></p>
    <p><? echo $info->intro ?></p>
  </div>
</div>
<h3 class="text-center"><? echo $chapter->title ?></h3>
<nav aria-label="...">
  <ul class="pager">
    <li>
      <a href="/chapter?source=<? echo $source['key'] ?>&novel=<? echo $info_id ?>&chapter=<? echo $chapter->prev->id ?>" style="<? echo $chapter->prev->id ? '' : 'cursor:pointer;pointer-events: none;color: #ccc;' ?>">
        <span aria-hidden="true">&larr;</span> 上一章
      </a>
    </li>
    <li><a href="/">书架</a></li>
    <li><a href="/catalog?source=<? echo $source['key'] ?>&novel=<? echo $info_id ?>&order=desc">目录</a></li>
    <li><a href="#" type="button" class="btn" onclick='insert_shelf("{\"name\":\"<? echo $info->name ?>\",\"source\":\"<? echo $source["key"] ?>\",\"cover\":\"<? echo $info->cover ?>\",\"id\":\"<? echo $info->id ?>\",\"chapter\":\"\"}")'><i class="glyphicon glyphicon-plus"></i>加入书架</a></li>
    <li>
      <a href="/chapter?source=<? echo $source['key'] ?>&novel=<? echo $info_id ?>&chapter=<? echo $chapter->next->id ?>" style="<? echo $chapter->next->id ? '' : 'cursor:pointer;pointer-events: none;color: #ccc;' ?>">
        下一章 <span aria-hidden="true">&rarr;</span>
      </a>
    </li>
  </ul>
</nav>
<div class="" style="font-size: 18px;">
  <? echo $chapter->content ?>
</div>
<nav aria-label="...">
  <ul class="pager">
    <li><a href="/chapter?source=<? echo $source['key'] ?>&novel=<? echo $info_id ?>&chapter=<? echo $chapter->prev->id ?>" style="<? echo $chapter->prev->id ? '' : 'cursor:pointer;pointer-events: none;color: #ccc;' ?>">
        <span aria-hidden="true">&larr;</span> 上一章
      </a>
    </li>
    <li><a href="/">书架</a></li>
    <li><a href="/catalog?source=<? echo $source['key'] ?>&novel=<? echo $info_id ?>&order=desc">目录</a></li>
    <li><a href="#" type="button" class="btn" onclick='insert_shelf("{\"name\":\"<? echo $info->name ?>\",\"source\":\"<? echo $source["key"] ?>\",\"cover\":\"<? echo $info->cover ?>\",\"id\":\"<? echo $info->id ?>\",\"chapter\":\"\"}")'><i class="glyphicon glyphicon-plus"></i>加入书架</a></li>
    <li><a href="/chapter?source=<? echo $source['key'] ?>&novel=<? echo $info_id ?>&chapter=<? echo $chapter->next->id ?>" style="<? echo $chapter->next->id ? '' : 'cursor:pointer;pointer-events: none;color: #ccc;' ?>">
        下一章 <span aria-hidden="true">&rarr;</span>
      </a>
    </li>
  </ul>
</nav>