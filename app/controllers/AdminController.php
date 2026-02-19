<?php
class AdminController {
  public static function dashboard(): void {
    Auth::requireAdmin();

    $pdo = DB::pdo();
    $users = $pdo->query("SELECT COUNT(*) AS c FROM users")->fetch()['c'] ?? 0;
    $threads = $pdo->query("SELECT COUNT(*) AS c FROM threads")->fetch()['c'] ?? 0;
    $posts = $pdo->query("SELECT COUNT(*) AS c FROM posts")->fetch()['c'] ?? 0;

    View::render('admin/dashboard', ['users'=>$users,'threads'=>$threads,'posts'=>$posts]);
  }

  public static function categories(): void {
    Auth::requireAdmin();
    $pdo = DB::pdo();
    $cats = $pdo->query("SELECT * FROM categories ORDER BY sort_order ASC, id ASC")->fetchAll();
    View::render('admin/categories', ['categories'=>$cats]);
  }

  public static function createCategory(): void {
    Auth::requireAdmin();
    Csrf::verify($_POST['csrf'] ?? null);

    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $sort = (int)($_POST['sort_order'] ?? 0);

    if ($name === '' || $slug === '') redirect('/admin/categories');

    $pdo = DB::pdo();
    $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, sort_order) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $slug, $desc ?: null, $sort]);

    redirect('/admin/categories');
  }

  public static function users(): void {
    Auth::requireAdmin();
    $pdo = DB::pdo();
    $users = $pdo->query("SELECT id, username, email, is_admin, created_at FROM users ORDER BY created_at DESC LIMIT 200")->fetchAll();
    View::render('admin/users', ['users'=>$users]);
  }

  public static function makeAdmin(int $id): void {
    Auth::requireAdmin();
    Csrf::verify($_POST['csrf'] ?? null);

    $pdo = DB::pdo();
    $pdo->prepare("UPDATE users SET is_admin = 1 WHERE id = ?")->execute([$id]);

    redirect('/admin/users');
  }
}
