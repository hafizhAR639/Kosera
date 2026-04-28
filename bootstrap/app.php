<?php

/**
 * Application bootstrap.
 *
 * Loads Composer autoloader, configuration, starts the session,
 * and returns the configured Router instance.
 */

// 1. Composer autoload (mandatory)
require_once __DIR__ . '/../vendor/autoload.php';

// 2. Load configuration
use App\Core\Config;
use App\Core\Auth;
use App\Core\Router;

Config::load(__DIR__ . '/../config.php');

// 3. Start session
Auth::startSession();

// 4. Build and return the router
$router = new Router();
$routeRegistrar = require __DIR__ . '/../config/routes.php';
$routeRegistrar($router);

return $router;
