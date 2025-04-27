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
    <?php _e($content['style']) ?>
  </style>
</head>

<body>
  <?php _e($content['html']) ?>

  <script crossorigin="anonymous" src="https://unpkg.com/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script crossorigin="anonymous" src="https://unpkg.com/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script crossorigin="anonymous" src="https://unpkg.com/mockjs@1.1.0/dist/mock-min.js"></script>
  <script crossorigin="anonymous" src="https://unpkg.com/holderjs@2.9.9/holder.min.js"></script>

  <script crossorigin="anonymous" src="script.js"></script>
  <script>
    <?php _e($content['script']) ?>
  </script>
</body>

</html>