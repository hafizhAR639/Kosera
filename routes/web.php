<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Mitra\DashboardController;
use App\Http\Controllers\Mitra\PortfolioController;
use App\Http\Controllers\Mitra\CertificateController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Mitra Routes
Route::middleware('auth')->prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('portfolio', PortfolioController::class);
    Route::resource('certificate', CertificateController::class);
});
