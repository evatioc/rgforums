<?php
class Auth {
  public static function user(): ?array {
    return $_SESSION['user'] ?? null;
  }

  public static function check(): bool {
    return !empty($_SESSION['user']);
  }

  public static function requireLogin(): void {
    if (!self::check()) redirect('/login');
  }

  public static function requireAdmin(): void {
    self::requireLogin();
    if (empty($_SESSION['user']['is_admin'])) {
      http_response_code(403);
      exit('Forbidden');
    }
  }

  public static function login(array $user): void {
    $_SESSION['user'] = [
      'id' => (int)$user['id'],
      'username' => $user['username'],
      'email' => $user['email'],
      'is_admin' => (int)$user['is_admin'],
    ];
  }

  public static function logout(): void {
    unset($_SESSION['user']);
  }
}
