<?php

$router = require __DIR__ . '/bootstrap/app.php';
$route = $_GET['r'] ?? null;

if ($route === null || $route === '') {
	$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
	$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
	$basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

	if ($basePath !== '' && $basePath !== '/' && strpos($requestPath, $basePath) === 0) {
		$requestPath = substr($requestPath, strlen($basePath));
	}

	// Treat direct access to index.php as application root.
	if ($requestPath === '' || $requestPath === '/' || $requestPath === '/index.php') {
		$route = '/';
	} else {
		$route = preg_replace('#/index\.php$#', '', $requestPath) ?: '/';
	}
}

$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $route);
