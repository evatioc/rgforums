<?php
function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

function redirect(string $path): void {
  header("Location: {$path}");
  exit;
}
