<?php

namespace App\Core;

class Router
{
    /** @var array<string, array<string, callable|array{string,string}>> */
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    /** @param callable|array{string,string} $handler */
    public function get(string $path, $handler): void
    {
        $this->routes['GET'][$this->normalize($path)] = $handler;
    }

    /** @param callable|array{string,string} $handler */
    public function post(string $path, $handler): void
    {
        $this->routes['POST'][$this->normalize($path)] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $method = strtoupper($method);
        $path = $this->normalize($uri);
        $handler = $this->routes[$method][$path] ?? null;

        if ($handler === null) {
            http_response_code(404);
            echo '404 - Halaman tidak ditemukan';
            return;
        }

        if (is_array($handler)) {
            [$className, $action] = $handler;
            $controller = new $className();
            $controller->{$action}();
            return;
        }

        $handler();
    }

    private function normalize(string $path): string
    {
        $path = trim($path);
        $path = parse_url($path, PHP_URL_PATH) ?: '/';
        $path = '/' . trim($path, '/');

        return $path === '//' ? '/' : $path;
    }
}
