<?php
class AuthController {
  public static function showLogin(): void {
    View::render('auth/login');
  }

  public static function login(): void {
    Csrf::verify($_POST['csrf'] ?? null);

    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    $pdo = DB::pdo();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($pass, $user['password_hash'])) {
      View::render('auth/login', ['error' => 'Invalid email or password.']);
      return;
    }

    Auth::login($user);
    redirect('/');
  }

  public static function showRegister(): void {
    View::render('auth/register');
  }

  public static function register(): void {
    Csrf::verify($_POST['csrf'] ?? null);

    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $pass     = $_POST['password'] ?? '';

    if (strlen($username) < 3 || strlen($pass) < 8 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      View::render('auth/register', ['error' => 'Check your username, email, and password (8+ chars).']);
      return;
    }

    $pdo = DB::pdo();
    $hash = password_hash($pass, PASSWORD_DEFAULT);

    try {
      $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
      $stmt->execute([$username, $email, $hash]);
    } catch (Throwable $e) {
      View::render('auth/register', ['error' => 'Username or email already exists.']);
      return;
    }

    // Auto login
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    Auth::login($user);

    redirect('/');
  }

  public static function logout(): void {
    Auth::logout();
    redirect('/');
  }
}
