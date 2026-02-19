<h1>Users</h1>

<div class="panel">
  <div class="list">
    <?php foreach ($users as $u): ?>
      <div class="item row-between">
        <div>
          <div class="title"><?= e($u['username']) ?> <?= ((int)$u['is_admin']===1) ? '<span class="pill">admin</span>' : '' ?></div>
          <div class="muted"><?= e($u['email']) ?> • joined <?= e($u['created_at']) ?></div>
        </div>

        <?php if ((int)$u['is_admin'] !== 1): ?>
          <form method="post" action="/admin/users/<?= (int)$u['id'] ?>/make-admin">
            <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>" />
            <button class="btn" type="submit">Make Admin</button>
          </form>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>
