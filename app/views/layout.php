<?php require __DIR__ . '/../assets_bootstrap.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?= e($site_name) ?></title>
  <style><?php $cssFile = __DIR__ . '/../assets/style.css'; if (is_file($cssFile)) { echo file_get_contents($cssFile); } ?></style>
</head>
<body>
  <header class="topbar">
    <div class="wrap row">
      <a class="brand" href="/">
        <span class="dot"></span>
        <span><?= e($site_name) ?></span>
      </a>

      <nav class="nav">
        <a href="/">Forums</a>
        <?php if (Auth::check()): ?>
          <?php if (!empty(Auth::user()['is_admin'])): ?>
            <a href="/admin">Admin</a>
          <?php endif; ?>
          <span class="chip">Hi, <?= e(Auth::user()['username']) ?></span>
          <a class="btn ghost" href="/logout">Logout</a>
        <?php else: ?>
          <a class="btn ghost" href="/login">Login</a>
          <a class="btn primary" href="/register">Register</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="wrap">
    <?php require $viewFile; ?>
  </main>

  <script src="/assets/app.js"></script>
</body>
</html>
