<?php require __DIR__ . '/../assets_bootstrap.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?= e($title ?? $site_name) ?></title>
  <style><?php $cssFile = __DIR__ . '/../assets/style.css'; if (is_file($cssFile)) { echo file_get_contents($cssFile); } ?></style>
</head>
<body>
  <div class="bg-glow" aria-hidden="true"></div>

  <header class="site-header">
    <div class="container header-row">
      <a class="brand" href="/" aria-label="Home">
        <span class="brand-mark" aria-hidden="true"></span>
        <span class="brand-text">Refined Roleplay</span>
      </a>

      <nav class="nav" aria-label="Primary">
        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="navLinks">
          <span class="nav-toggle-bars" aria-hidden="true"></span>
          <span class="sr-only">Menu</span>
        </button>

        <div id="navLinks" class="nav-links">
          <a href="/">Home</a>
          <a href="/forum">Forums</a>
          <a href="/team">Team</a>
          <a href="/faq">FAQ</a>
          <a href="https://store.example.com" target="_blank">Store</a>
          
          <?php if (Auth::check()): ?>
            <?php if (!empty(Auth::user()['is_admin'])): ?>
              <a href="/admin">Admin</a>
            <?php endif; ?>
            <a href="#" class="chip">Hi, <?= e(Auth::user()['username']) ?></a>
            <a href="/logout">Logout</a>
          <?php else: ?>
            <a href="/login">Login</a>
            <a href="/register" class="btn btn-primary" style="padding: 6px 12px; font-size: 14px;">Register</a>
          <?php endif; ?>
        </div>
      </nav>
    </div>
  </header>

  <main class="container" style="padding-top: 20px; padding-bottom: 40px;">
    <?php require $viewFile; ?>
  </main>

  <footer class="footer">
    <div class="container footer-row">
      <div class="footer-left">
        <div class="brand small-brand">
          <span class="brand-mark" aria-hidden="true"></span>
          <span class="brand-text">Refined Roleplay</span>
        </div>
        <p class="muted">© <span id="year"></span> Refined Roleplay. All rights reserved.</p>
      </div>
      <div class="footer-links">
        <a href="/forum">Forums</a>
        <a href="/rules">Rules</a> <!-- Needs a page or anchor? -->
        <a href="/team.html">Team</a>
      </div>
    </div>
  </footer>

  <div class="toast" id="toast" role="status" aria-live="polite" aria-atomic="true"></div>
  <script src="/assets/app.js"></script>
</body>
</html>
