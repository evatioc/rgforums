<?php
class ForumController {
  public static function home(): void {
    $pdo = DB::pdo();
    $cats = $pdo->query("SELECT * FROM categories ORDER BY sort_order ASC, id ASC")->fetchAll();

    // Enrich categories with stats
    foreach ($cats as &$c) {
      $stmt = $pdo->prepare("SELECT COUNT(*) FROM threads WHERE category_id = ?");
      $stmt->execute([$c['id']]);
      $c['thread_count'] = $stmt->fetchColumn();

      $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM posts p 
        JOIN threads t ON t.id = p.thread_id 
        WHERE t.category_id = ?
      ");
      $stmt->execute([$c['id']]);
      $c['post_count'] = $stmt->fetchColumn();

      // Last post
      $stmt = $pdo->prepare("
        SELECT p.created_at, u.username, t.title, t.id as thread_id
        FROM posts p
        JOIN threads t ON t.id = p.thread_id
        JOIN users u ON u.id = p.user_id
        WHERE t.category_id = ?
        ORDER BY p.created_at DESC
        LIMIT 1
      ");
      $stmt->execute([$c['id']]);
      $c['last_post'] = $stmt->fetch();
    }
    unset($c);

    // Latest posts for Sidebar
    // We'll fetch latest threads for now as it's cleaner
    $sidebar = $pdo->query("
      SELECT t.*, c.name AS category_name, c.slug AS category_slug, u.username,
             (SELECT COUNT(*) FROM posts p WHERE p.thread_id = t.id) - 1 as replies
      FROM threads t
      JOIN categories c ON c.id = t.category_id
      JOIN users u ON u.id = t.user_id
      ORDER BY t.updated_at DESC
      LIMIT 5
    ")->fetchAll();

    View::render('home', ['categories'=>$cats, 'sidebar_threads'=>$sidebar, 'title' => 'Forums | Refined Roleplay']);
  }

  public static function category(string $slug): void {
    $pdo = DB::pdo();

    $stmt = $pdo->prepare("SELECT * FROM categories WHERE slug = ? LIMIT 1");
    $stmt->execute([$slug]);
    $cat = $stmt->fetch();
    if (!$cat) { http_response_code(404); exit('Category not found'); }

    $stmt = $pdo->prepare("
      SELECT t.*, u.username,
        (SELECT COUNT(*) FROM posts p WHERE p.thread_id = t.id) AS replies
      FROM threads t
      JOIN users u ON u.id = t.user_id
      WHERE t.category_id = ?
      ORDER BY t.created_at DESC
    ");
    $stmt->execute([$cat['id']]);
    $threads = $stmt->fetchAll();

    View::render('forum/category', ['category'=>$cat, 'threads'=>$threads]);
  }

  public static function showNewThread(string $slug): void {
    Auth::requireLogin();

    $pdo = DB::pdo();
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE slug = ? LIMIT 1");
    $stmt->execute([$slug]);
    $cat = $stmt->fetch();
    if (!$cat) { http_response_code(404); exit('Category not found'); }

    View::render('forum/new_thread', ['category'=>$cat]);
  }

  public static function createThread(string $slug): void {
    Auth::requireLogin();
    Csrf::verify($_POST['csrf'] ?? null);

    $title = trim($_POST['title'] ?? '');
    $body  = trim($_POST['body'] ?? '');
    if ($title === '' || $body === '') {
      redirect("/c/$slug/new?err=1");
    }

    $pdo = DB::pdo();
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE slug = ? LIMIT 1");
    $stmt->execute([$slug]);
    $cat = $stmt->fetch();
    if (!$cat) { http_response_code(404); exit('Category not found'); }

    $pdo->beginTransaction();
    try {
      $stmt = $pdo->prepare("INSERT INTO threads (category_id, user_id, title) VALUES (?, ?, ?)");
      $stmt->execute([(int)$cat['id'], (int)Auth::user()['id'], $title]);
      $threadId = (int)$pdo->lastInsertId();

      $stmt = $pdo->prepare("INSERT INTO posts (thread_id, user_id, body) VALUES (?, ?, ?)");
      $stmt->execute([$threadId, (int)Auth::user()['id'], $body]);

      $pdo->commit();
    } catch (Throwable $e) {
      $pdo->rollBack();
      http_response_code(500);
      exit('Failed to create thread.');
    }

    redirect("/t/$threadId");
  }

  public static function thread(int $id): void {
    $pdo = DB::pdo();

    $stmt = $pdo->prepare("
      SELECT t.*, c.name AS category_name, c.slug AS category_slug, u.username
      FROM threads t
      JOIN categories c ON c.id = t.category_id
      JOIN users u ON u.id = t.user_id
      WHERE t.id = ?
      LIMIT 1
    ");
    $stmt->execute([$id]);
    $thread = $stmt->fetch();
    if (!$thread) { http_response_code(404); exit('Thread not found'); }

    $stmt = $pdo->prepare("
      SELECT p.*, u.username
      FROM posts p
      JOIN users u ON u.id = p.user_id
      WHERE p.thread_id = ?
      ORDER BY p.created_at ASC
    ");
    $stmt->execute([$id]);
    $posts = $stmt->fetchAll();

    View::render('forum/thread', ['thread'=>$thread, 'posts'=>$posts]);
  }

  public static function reply(int $id): void {
    Auth::requireLogin();
    Csrf::verify($_POST['csrf'] ?? null);

    $body = trim($_POST['body'] ?? '');
    if ($body === '') redirect("/t/$id");

    $pdo = DB::pdo();
    $stmt = $pdo->prepare("SELECT is_locked FROM threads WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $t = $stmt->fetch();
    if (!$t) { http_response_code(404); exit('Thread not found'); }
    if ((int)$t['is_locked'] === 1) { http_response_code(403); exit('Thread locked'); }

    $stmt = $pdo->prepare("INSERT INTO posts (thread_id, user_id, body) VALUES (?, ?, ?)");
    $stmt->execute([$id, (int)Auth::user()['id'], $body]);

    $pdo->prepare("UPDATE threads SET updated_at = NOW() WHERE id = ?")->execute([$id]);

    redirect("/t/$id");
  }
}
