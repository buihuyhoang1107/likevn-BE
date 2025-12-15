<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Services (public)
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{id}', [ServiceController::class, 'show']);
Route::get('/services/{serviceId}/servers', [ServiceController::class, 'getServers']);
Route::post('/calculate-price', [ServiceController::class, 'calculatePrice']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // User
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::get('/balance', [UserController::class, 'getBalance']);

    // Orders
    Route::post('/orders', [OrderController::class, 'create']);
    Route::get('/orders', [OrderController::class, 'myOrders']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    // Admin routes
    Route::prefix('admin')->group(function () {
        // Users
        Route::get('/users', [AdminController::class, 'getUsers']);
        Route::get('/users/{id}', [AdminController::class, 'getUser']);
        Route::post('/users', [AdminController::class, 'createUser']);
        Route::put('/users/{id}', [AdminController::class, 'updateUser']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);

        // Orders
        Route::get('/orders', [AdminController::class, 'getOrders']);
        Route::get('/orders/{id}', [AdminController::class, 'getOrder']);
        Route::put('/orders/{id}', [AdminController::class, 'updateOrder']);
        Route::delete('/orders/{id}', [AdminController::class, 'deleteOrder']);

        // Services
        Route::get('/services', [AdminController::class, 'getServices']);
        Route::get('/services/{id}', [AdminController::class, 'getService']);
        Route::post('/services', [AdminController::class, 'createService']);
        Route::put('/services/{id}', [AdminController::class, 'updateService']);
        Route::delete('/services/{id}', [AdminController::class, 'deleteService']);

        // Servers
        Route::get('/servers', [AdminController::class, 'getServers']);
        Route::get('/servers/{id}', [AdminController::class, 'getServer']);
        Route::post('/servers', [AdminController::class, 'createServer']);
        Route::put('/servers/{id}', [AdminController::class, 'updateServer']);
        Route::delete('/servers/{id}', [AdminController::class, 'deleteServer']);

        // Settings
        Route::get('/settings', [AdminController::class, 'getSettings']);
        Route::put('/settings', [AdminController::class, 'updateSettings']);
        
        // Platforms
        Route::get('/platforms', [AdminController::class, 'getPlatforms']);
    });
});

