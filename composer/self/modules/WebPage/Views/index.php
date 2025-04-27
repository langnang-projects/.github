<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>WebPage</title>

  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/normalize.css@8.0.1/normalize.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/animate.css@4.1.1/animate.min.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link crossorigin="anonymous" rel="stylesheet" href="style.css">
  <style>

  </style>
</head>

<body>
  <div id="app" class="container">
    <h1 class="text-center"><?php _e($title) ?></h1>

    <div class="row row-cols-3">
      <?php foreach ($contents as $content): ?>
        <div class="col">
          <a href="/webpage/<?php _e($content['cid']) ?>">
            <iframe src="/webpage/<?php _e($content['cid']) ?>" frameborder="0" width="100%"></iframe>
          </a>
        </div>
      <?php endforeach ?>
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