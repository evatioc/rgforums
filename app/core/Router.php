<?php
class Router {
  private array $routes = ['GET'=>[], 'POST'=>[]];

  public function get(string $path, callable $handler): void { $this->routes['GET'][$path] = $handler; }
  public function post(string $path, callable $handler): void { $this->routes['POST'][$path] = $handler; }

  public function dispatch(string $method, string $path): void {
    $path = '/' . trim($path, '/');
    $routes = $this->routes[$method] ?? [];

    // Exact match first
    if (isset($routes[$path])) {
      $this->invoke($routes[$path], []);
      return;
    }

    // Pattern match (e.g. /c/:slug, /t/:id)
    foreach ($routes as $route => $handler) {
      if (str_contains($route, ':')) {
        $pattern = preg_replace('#:([a-zA-Z_]+)#', '([^/]+)', $route);
        $pattern = '#^' . $pattern . '$#';
        if (preg_match($pattern, $path, $m)) {
          array_shift($m);
          $this->invoke($handler, $m);
          return;
        }
      }
    }

    http_response_code(404);
    exit('Not Found');
  }

  private function invoke(callable $handler, array $args): void {
    call_user_func_array($handler, $args);
  }
}
