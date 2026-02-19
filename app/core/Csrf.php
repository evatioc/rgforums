<?php
class Csrf {
  public static function token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
  }

  public static function verify(?string $token): void {
    if (!$token || empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $token)) {
      http_response_code(403);
      exit('CSRF check failed.');
    }
  }
}
