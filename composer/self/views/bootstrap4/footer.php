<footer class="p-3" style="background-color: #18171B;color: aliceblue;">
  <div class="container text-center">
    <div class="row row-cols-3">
      <div class="col">
        <div class="card bg-transparent">
          <div class="card-header py-2">
            <a href="#"><b>Illuminates</b></a>
          </div>
          <div class="list-group bg-transparent list-group-flush">
            <a class="list-group-item list-group-item-action py-1 bg-transparent text-light" href="#">Application</a>
            <a class="list-group-item list-group-item-action py-1 bg-transparent text-light" href="#">Config</a>
            <a class="list-group-item list-group-item-action py-1 bg-transparent text-light" href="#">Database</a>
            <a class="list-group-item list-group-item-action py-1 bg-transparent text-light" href="#">Router</a>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card bg-transparent">
          <div class="card-header py-2">
            <a href="#"><b>Modules</b></a>
          </div>
          <div class="list-group bg-transparent list-group-flush">
            <a class="list-group-item list-group-item-action py-1 bg-transparent text-light" href="/market">Market</a>
            <a class="list-group-item list-group-item-action py-1 bg-transparent text-light" href="/manual">Manual</a>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card bg-transparent">
          <div class="card-header py-2">
            <a href="#"><b>Auxiliary</b></a>
          </div>
          <div class="list-group bg-transparent list-group-flush">
            <a class="list-group-item list-group-item-action py-1 bg-transparent text-light" href="#">Helpers</a>
            <a class="list-group-item list-group-item-action py-1 bg-transparent text-light" href="/test">Tests</a>
            <a class="list-group-item list-group-item-action py-1 bg-transparent text-light" href="/app/logs">Logs</a>
            <a class="list-group-item list-group-item-action py-1 bg-transparent text-light" href="/phpinfo.php">PhpInfo</a>
          </div>
        </div>

      </div>
    </div>
    <div class="row">
      <div class="col-12 text-right">
        PHP: <?php _e(phpversion()); ?>
        Time: <?php _e(round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 5)); ?> Sec.
        Size: <?php _e(round(ob_get_length() / 1024, 5)); ?> KB.
      </div>
    </div>
  </div>
</footer>