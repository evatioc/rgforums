<h1>Login</h1>

<?php if (!empty($error)): ?>
  <div class="alert"><?= e($error) ?></div>
<?php endif; ?>

<form class="panel form" method="post" action="/login">
  <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>" />
  <label><span>Email</span><input name="email" type="email" required /></label>
  <label><span>Password</span><input name="password" type="password" required /></label>
  <button class="btn primary" type="submit">Login</button>
  <p class="muted">No account? <a href="/register"><strong>Register</strong></a></p>
</form>
