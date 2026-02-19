<section class="grid">
  <aside class="panel">
    <h2>Categories</h2>
    <div class="list">
      <?php foreach ($categories as $c): ?>
        <a class="item" href="/c/<?= e($c['slug']) ?>">
          <div class="title"><?= e($c['name']) ?></div>
          <div class="muted"><?= e($c['description'] ?? '') ?></div>
        </a>
      <?php endforeach; ?>
    </div>
  </aside>

  <section class="panel">
    <h2>Latest</h2>
    <div class="list">
      <?php foreach ($threads as $t): ?>
        <a class="item" href="/t/<?= (int)$t['id'] ?>">
          <div class="title"><?= e($t['title']) ?></div>
          <div class="muted">
            in <strong><?= e($t['category_name']) ?></strong> • by <?= e($t['username']) ?> • <?= e($t['created_at']) ?>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </section>
</section>
