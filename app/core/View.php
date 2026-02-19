<?php
class View {
  public static function render(string $view, array $data = []): void {
    extract($data);
    $cfg = require __DIR__ . '/../config.php';
    $site_name = $cfg['app']['site_name'];

    $viewFile = __DIR__ . '/../views/' . $view . '.php';
    if (!file_exists($viewFile)) { http_response_code(500); exit('View not found'); }

    require __DIR__ . '/../views/layout.php';
  }
}
