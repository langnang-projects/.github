<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php _e($title); ?></title>

  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/normalize.css@8.0.1/normalize.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/animate.css@4.1.1/animate.min.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link crossorigin="anonymous" rel="stylesheet" href="style.css">
</head>

<body>
  <div id="app" class="container">
    <h1 class="text-center"><?php _e($title) ?></h1>
    <h2>Illuminates</h2>
    <div class="row">
      <div class="col-3">3</div>
      <div class="col-6">6</div>
      <div class="col-3">3</div>
    </div>
    <div class="row row-cols-3">
      <?php foreach ($illuminates as $illuminate): ?>
        <div class="col my-2 px-2">
          <div class="card">
            <div class="card-body p-3">
              <h5><?php _e($illuminate->name) ?> <small><i>(<?php _e($illuminate->alias) ?>)</i></small></h5>
              <p class="small mb-0">
                <a href="#<?php _e($illuminate->alias) ?>.adapter">Adapter</a>
                <a href="#<?php _e($illuminate->alias) ?>.class">Class</a>
                <a href="#<?php _e($illuminate->alias) ?>.config">Config</a>
                <a href="#<?php _e($illuminate->alias) ?>.contract">Contract</a>
                <a href="#<?php _e($illuminate->alias) ?>.driver">Driver</a>
                <a href="#<?php _e($illuminate->alias) ?>.facade">Facade</a>
                <a href="#<?php _e($illuminate->alias) ?>.interface">Interface</a>
                <a href="#<?php _e($illuminate->alias) ?>.trait">Trait</a>
              </p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <h2>Modules</h2>
    <div class="row row-cols-3">
      <?php foreach ($modules as $module): ?>
        <div class="col my-2 px-2">
          <div class="card">
            <div class="card-body p-3">
              <h5><?php _e($module['name']) ?> <small><i>(<?php _e($module['alias']) ?>)</i></small></h5>
              <p class="small mb-0">
                <a href="#<?php _e($module['alias']) ?>.adapter">Adapter</a>
                <a href="#<?php _e($module['alias']) ?>.class">Class</a>
                <a href="#<?php _e($module['alias']) ?>.config">Config</a>
                <a href="#<?php _e($module['alias']) ?>.contract">Contract</a>
                <a href="#<?php _e($module['alias']) ?>.driver">Driver</a>
                <a href="#<?php _e($module['alias']) ?>.facade">Facade</a>
                <a href="#<?php _e($module['alias']) ?>.interface">Interface</a>
                <a href="#<?php _e($module['alias']) ?>.trait">Trait</a>
              </p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php require_once __DIR__ . '/footer.php' ?>
  </div>

  <script crossorigin="anonymous" src="https://unpkg.com/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script crossorigin="anonymous" src="https://unpkg.com/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script crossorigin="anonymous" src="https://unpkg.com/mockjs@1.1.0/dist/mock-min.js"></script>
  <script crossorigin="anonymous" src="https://unpkg.com/holderjs@2.9.9/holder.min.js"></script>

  <script crossorigin="anonymous" src="script.js"></script>
</body>

</html>