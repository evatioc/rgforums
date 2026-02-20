<?php
/**
 * RG-Website – Forum entry point
 * Requires: PHP 8+, MySQL, Apache with mod_rewrite
 */

session_start();

define('ROOT', __DIR__);
define('APP', ROOT . '/app');

require APP . '/core/Helpers.php';
require APP . '/core/DB.php';
require APP . '/core/Auth.php';
require APP . '/core/Csrf.php';
require APP . '/core/View.php';
require APP . '/core/Router.php';
require APP . '/controllers/AuthController.php';
require APP . '/controllers/ForumController.php';
require APP . '/controllers/PageController.php';
require APP . '/controllers/AdminController.php';

$cfg = require APP . '/config.php';
$base = rtrim($cfg['app']['base_url'] ?? '', '/');

// Path from rewrite _url or REQUEST_URI (ensure leading slash, no trailing)
$raw = isset($_GET['_url']) ? $_GET['_url'] : parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$path = '/' . trim(trim((string)$raw, '/'));
$path = preg_replace('#^' . preg_quote($base, '#') . '#', '', $path);
$path = $path !== '' ? $path : '/';

$router = new Router();

// Auth
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

// Pages
$router->get('/', [PageController::class, 'landing']);
$router->get('/team', [PageController::class, 'team']);
$router->get('/faq', [PageController::class, 'faq']);

// Forum
$router->get('/forum', [ForumController::class, 'home']);
$router->get('/forum', [ForumController::class, 'home']);
$router->get('/c/:slug', [ForumController::class, 'category']);
$router->get('/c/:slug/new', [ForumController::class, 'showNewThread']);
$router->post('/c/:slug/new', [ForumController::class, 'createThread']);
$router->get('/t/:id', function ($id) { ForumController::thread((int) $id); });
$router->post('/t/:id/reply', function ($id) { ForumController::reply((int) $id); });

// Admin
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/categories', [AdminController::class, 'categories']);
$router->post('/admin/categories', [AdminController::class, 'createCategory']);
$router->get('/admin/users', [AdminController::class, 'users']);
$router->post('/admin/users/:id/make-admin', function ($id) { AdminController::makeAdmin((int) $id); });

$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $path);
