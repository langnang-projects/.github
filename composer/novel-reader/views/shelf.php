<title>Novel Reader - Langnang</title>
<style>
  .jumbotron p {
    font-size: 14px;
    margin-bottom: 5px;
  }
</style>
<div class="row" name="shelf">
</div>
<script>
  for (let n in shelf) {
    const novel = shelf[n];
    $("[name='shelf']").append(`
      <a href="/catalog?source=${novel.source}&novel=${novel.id}" style="text-decoration: none;">
        <div class="col-12">
          <div class="jumbotron text-info" style="padding:10px 15px;">
            <h3>${novel.name}</h3>
            <p>阅读章节</p>
            <p>最新章节</p>
          </div>
          <div class="thumbnail" style="position:relative;background:#ccc;">
            <h4>${novel.name}</h4>
            <h4 class="text-center" style="position:absolute;width:100%;bottom:10px;">${novel.name}</h4>
          </div>
        </div>
      </a>
      `)
  }
</script>