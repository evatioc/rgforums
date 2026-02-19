<div class="head">
  <h1><?= e($category['name']) ?></h1>
  <a class="btn primary" href="/c/<?= e($category['slug']) ?>/new">New thread</a>
</div>
<p class="muted"><?= e($category['description'] ?? '') ?></p>

<div class="list">
  <?php foreach ($threads as $t): ?>
    <a class="item" href="/t/<?= (int)$t['id'] ?>">
      <div class="row-between">
        <span class="title"><?= e($t['title']) ?></span>
        <span class="k"><?= (int)$t['replies'] ?> replies</span>
      </div>
      <div class="muted">by <?= e($t['username']) ?> • <?= e($t['created_at']) ?></div>
    </a>
  <?php endforeach; ?>
</div>

<?php if (empty($threads)): ?>
  <p class="muted">No threads yet. <a href="/c/<?= e($category['slug']) ?>/new">Create the first one</a>.</p>
<?php endif; ?>
