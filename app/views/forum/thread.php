<div class="head">
  <div>
    <h1><?= e($thread['title']) ?></h1>
    <p class="muted">
      in <a href="/c/<?= e($thread['category_slug']) ?>"><strong><?= e($thread['category_name']) ?></strong></a>
      • by <?= e($thread['username']) ?> • <?= e($thread['created_at']) ?>
    </p>
  </div>
</div>

<div class="panel">
  <?php foreach ($posts as $p): ?>
    <div class="post">
      <div class="post-meta">
        <strong><?= e($p['username']) ?></strong>
        <span class="muted"><?= e($p['created_at']) ?></span>
      </div>
      <div class="post-body"><?= nl2br(e($p['body'])) ?></div>
    </div>
  <?php endforeach; ?>
</div>

<?php if (Auth::check()): ?>
  <form class="panel form" method="post" action="/t/<?= (int)$thread['id'] ?>/reply">
    <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>" />
    <label>
      <span>Reply</span>
      <textarea name="body" rows="5" required></textarea>
    </label>
    <button class="btn primary" type="submit">Post Reply</button>
  </form>
<?php else: ?>
  <div class="panel muted">Login to reply.</div>
<?php endif; ?>
