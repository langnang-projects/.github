<?php require_once __DIR__ . '/layout/head.php'; ?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<main class="container">
  <h1 class="text-center">Bootstrap v4</h1>
  <div class="row">
    <div class="col">
      <div class="list-group">

        <?php foreach ($configs['contents'] ?? [] as $slug => $content): ?>
          <a href="<?php _e(config('this.alias')) ?>/content?slug=<?php echo $slug ?>" class="list-group-item list-group-item-action py-2">
            <?php echo $slug; ?>
            <small><?php echo $content['description'] ?? ''; ?></small>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
<?php require_once __DIR__ . '/layout/foot.php'; ?>