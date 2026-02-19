<h1>Register</h1>

<?php if (!empty($error)): ?>
  <div class="alert"><?= e($error) ?></div>
<?php endif; ?>

<form class="panel form" method="post" action="/register">
  <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>" />
  <label><span>Username</span><input name="username" minlength="3" maxlength="32" required /></label>
  <label><span>Email</span><input name="email" type="email" required /></label>
  <label><span>Password</span><input name="password" type="password" minlength="8" required /></label>
  <button class="btn primary" type="submit">Create Account</button>
  <p class="muted">Already have one? <a href="/login"><strong>Login</strong></a></p>
</form>
