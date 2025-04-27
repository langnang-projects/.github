<?

// var_dump($_GET);
$name = $_GET['name'];
$genuine = explode(",", $_GET['genuine']);
$non_genuine = explode(",", $_GET['non_genuine']);
$txt_genuine = explode(",", $_GET['txt_genuine']);
$genuines = array_merge($genuine, $non_genuine, $txt_genuine);
// var_dump($genuines);
$sources = [];
foreach ($genuines as $source_key) {
  if (is_null($source_key)) {
    continue;
  }
  $source = array_filter($_NOVEL_SOURCE, function ($item) use ($source_key) {
    return $item['key'] == $source_key;
  });
  if (!is_null($source)) {
    $sources = array_merge($sources, $source);
  }
}

// var_dump($sources);
// var_dump($name);
?>
<h3 class="text-center">Novel Reader - Langnang</h3>
<div class="row">
  <div class="col-12">
    <form>
      <div class="form-group">
        <div class="input-group input-group-lg">
          <span class="input-group-btn">
            <a href="/" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
          </span>
          <input type="text" class="form-control" name="name" aria-label="..." value="<? echo $name ?>">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button" onclick="search()">Go!</button>
          </span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">正版源</label>
        <? foreach (array_filter($_NOVEL_SOURCE, function ($source) {
          return $source['source'] == "genuine";
        }) as $source) : ?>
          <label class="checkbox-inline">
            <input type="checkbox" name="genuine" value="<? echo $source['key'] ?>" <? echo array_search($source['key'], $genuine) === false ? null : "checked"  ?>> <a target="_blank" href="<? echo $source['url'] ?>"><? echo $source['name'] ?></a>
          </label>
        <? endforeach; ?>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">非正版源</label>
        <? foreach (array_filter($_NOVEL_SOURCE, function ($source) {
          return $source['source'] == "non_genuine";
        }) as $source) : ?>
          <label class="checkbox-inline">
            <input type="checkbox" name="non_genuine" value="<? echo $source['key'] ?>" <? echo array_search($source['key'], $non_genuine) === false ? null : "checked" ?>> <a target="_blank" href="<? echo $source['url'] ?>"><? echo $source['name'] ?></a>
          </label>
        <? endforeach; ?>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">可下载源</label>
        <? foreach (array_filter($_NOVEL_SOURCE, function ($source) {
          return $source['source'] == "txt_genuine";
        }) as $source) : ?>
          <label class="checkbox-inline">
            <input type="checkbox" name="txt_genuine" value="<? echo $source['key'] ?>" <? echo array_search($source['key'], $txt_genuine) === false ? null : "checked" ?>> <a target="_blank" href="<? echo $source['url'] ?>"><? echo $source['name'] ?></a>
          </label>
        <? endforeach; ?>
      </div>
    </form>
  </div>
</div>
<? if (sizeof($sources) == 0 || empty($name)) : include_once(__DIR__ . "/shelf.php") ?>

<? else : ?>
  <title><? echo $name ?> | Novel Reader - Langnang</title>

  <ul class="nav nav-pills nav-justified" role="tablist">
    <? foreach ($sources as $index => $source) :  ?>
      <li role="presentation" class="<? echo $index === 0 ? 'active' : null ?>">
        <a href="#<? echo $source['key'] ?>" aria-controls="<? echo $source['key'] ?>" role="tab" data-toggle="tab"><? echo $source['name'] ?></a>
      </li>
    <? endforeach ?>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <? foreach ($sources as $index => $source) : ?>
      <div role="tabpanel" class="tab-pane <? echo $index === 0 ? 'active' : null ?>" id="<? echo $source['key'] ?>">
        <br>
        <? foreach ((new $source['class']())->spider_list_fields(urlencode($name))->list as $info) : ?>
          <div class="col-12">
            <a href="/catalog?source=<? echo $source['key'] ?>&novel=<? echo $info->id ?>&order=desc">
              <div class="row thumbnail">
                <div class="caption">
                  <h3>
                    <? echo $info->name ?>
                  </h3>
                  <p>作者：<? echo $info->author->name ?></p>
                  <p><? echo $info->latest_chapter->title ?></p>
                  <p><? echo $info->intro ?></p>

                </div>
              </div>
            </a>
            <button type="button" class="btn btn-default pull-right" style="position: absolute;top: 20px;right: 20px;z-index: 9;" onclick='insert_shelf("{\"name\":\"<? echo $info->name ?>\",\"source\":\"<? echo $source["key"] ?>\",\"cover\":\"<? echo $info->cover ?>\",\"id\":\"<? echo $info->id ?>\",\"chapter\":\"\"}")'><i class="glyphicon glyphicon-plus"></i>加入书架</button>
          </div>
        <? endforeach ?>
      </div>
    <? endforeach ?>
  </div>
<? endif ?>
<script>
  function search() {
    if ($("input[name='name']").val().trim() != '') {
      window.location.href = `/?name=${$("input[name='name']").val().trim()}&genuine=${[...$("input[name='genuine']:checked")].map(e => e.value).join()}&non_genuine=${[...$("input[name='non_genuine']:checked")].map(e => e.value).join()}&txt_genuine=${[...$("input[name='txt_genuine']:checked")].map(e => e.value).join()}`;
    }
  }
</script>