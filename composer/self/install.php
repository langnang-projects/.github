<?php

use Illuminate\Install\InstallStep;

$app = require_once __DIR__ . '/bootstrap/app.php';

Install::addStep(new InstallStep());
Install::addStep(new InstallStep());
Install::addStep(new InstallStep());
Install::addStep(new InstallStep());

$steps = app('install')->steps;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/normalize.css@8.0.1/normalize.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/animate.css@4.1.1/animate.min.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>

  </style>
</head>

<body>
  <header class="bg-dark text-white text-center" style="padding: 4rem 0;font-size: 2rem;">
    <div class="container">
      <div class="row row-cols-<?php _e(sizeof($steps)); ?>">
        <?php foreach (app('install')->steps as $index => $step) : ?>
          <div class="col">
            <a href="?step=<?php _e($index + 1) ?>" class="d-inline-block border rounded-circle text-decoration-none cursor-pointer" style="width: 3rem;">
              <?php _e($index + 1) ?>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </header>

  <script crossorigin="anonymous" src="https://unpkg.com/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script crossorigin="anonymous" src="https://unpkg.com/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script crossorigin="anonymous" src="https://unpkg.com/mockjs@1.1.0/dist/mock-min.js"></script>
  <script crossorigin="anonymous" src="https://unpkg.com/holderjs@2.9.9/holder.min.js"></script>
</body>

</html>