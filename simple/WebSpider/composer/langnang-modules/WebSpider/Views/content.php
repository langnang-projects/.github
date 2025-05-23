<?php require_once __DIR__ . '/layout/head.php'; ?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<main class="container">
  <h1 class="text-center">Bootstrap v4</h1>
  <div class="jumbotron">
    <h1 class="display-4">Hello, world!</h1>
    <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
    <hr class="my-4">
    <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
    <a class="btn btn-primary btn-lg" href="../<?php _e(config('this.alias')) ?>/ob-spider?<?php echo $_SERVER['QUERY_STRING']; ?>" role="button">Run</a>
  </div>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
<?php require_once __DIR__ . '/layout/foot.php'; ?>