<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    // Accept both controller array syntax and standard anonymous functions
    public function get(string $path, callable|array $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, callable|array $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve(Request $request): void
    {
        $path = $request->getPath();
        $method = $request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            http_response_code(404);
            echo "404 - Page Not Found";
            return;
        }

        // Authentication Guard
        Session::start();
        $isLoggedIn = Session::get('user_id') !== null;
        $isAdmin = Session::get('is_admin') === 1;

        // Protect all routes except login
        if ($path !== '/login' && (!$isLoggedIn || !$isAdmin)) {
            header('Location: /login');
            exit;
        }

        if ($path === '/login' && $isLoggedIn && $isAdmin) {
            header('Location: /users');
            exit;
        }

        // Handle closure or controller array execution dynamically
        if (is_array($callback)) {
            [$controllerClass, $action] = $callback;
            $controller = new $controllerClass();
            $controller->$action($request);
        } else {
            call_user_func($callback, $request);
        }
    }
}
