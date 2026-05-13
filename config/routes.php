<?php

use App\Controllers\Auth\AuthController;
use App\Controllers\Mitra\DashboardController;
use App\Controllers\Mitra\CertificateController;
use App\Controllers\Mitra\IncomingOrdersController;
use App\Controllers\Mitra\OrderHistoryController;
use App\Controllers\Mitra\PortfolioController;
use App\Controllers\Mitra\ProfileController;
use App\Core\Router;

return static function (Router $router): void {
    $router->get('/', [AuthController::class, 'welcome']);

    $router->get('/login', [AuthController::class, 'showLogin']);
    $router->post('/login', [AuthController::class, 'login']);

    $router->get('/register', [AuthController::class, 'showRegister']);
    $router->post('/register', [AuthController::class, 'register']);

    $router->get('/logout', [AuthController::class, 'logout']);
    $router->post('/logout', [AuthController::class, 'logout']);

    $router->get('/mitra/dashboard', [DashboardController::class, 'index']);

    $router->get('/mitra/orders/incoming', [IncomingOrdersController::class, 'index']);
    $router->post('/mitra/orders/incoming/status', [IncomingOrdersController::class, 'updateStatus']);

    $router->get('/mitra/orders/history', [OrderHistoryController::class, 'index']);
    $router->get('/mitra/orders/history/export-csv', [OrderHistoryController::class, 'exportCsv']);

    $router->get('/mitra/profile', [ProfileController::class, 'show']);
    $router->get('/mitra/profile/edit', [ProfileController::class, 'edit']);
    $router->post('/mitra/profile/edit', [ProfileController::class, 'update']);

    $router->get('/mitra/certificates', [CertificateController::class, 'index']);
    $router->post('/mitra/certificates/store', [CertificateController::class, 'store']);
    $router->post('/mitra/certificates/update', [CertificateController::class, 'update']);
    $router->post('/mitra/certificates/delete', [CertificateController::class, 'destroy']);

    $router->get('/mitra/portfolio', [PortfolioController::class, 'index']);
    $router->post('/mitra/portfolio/store', [PortfolioController::class, 'store']);
    $router->post('/mitra/portfolio/update', [PortfolioController::class, 'update']);
    $router->post('/mitra/portfolio/delete', [PortfolioController::class, 'destroy']);
};
