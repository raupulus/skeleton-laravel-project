<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryApiController;
use App\Http\Controllers\Api\V1\PageApiController;
use App\Http\Controllers\Api\V1\PostApiController;
use App\Http\Controllers\Api\V1\TokenController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // --- Autenticación (con rate limiting para prevenir fuerza bruta) ---
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])
            ->middleware('throttle:5,1')
            ->name('api.v1.auth.register');
        Route::post('/login', [AuthController::class, 'login'])
            ->middleware('throttle:10,1')
            ->name('api.v1.auth.login');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])
            ->middleware('throttle:3,1')
            ->name('api.v1.auth.forgot-password');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])
            ->middleware('throttle:5,1')
            ->name('api.v1.auth.reset-password');
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout'])->name('api.v1.auth.logout');
            Route::get('/user', [AuthController::class, 'user'])->name('api.v1.auth.user');
        });
    });

    // --- Posts (público) ---
    Route::get('/posts', [PostApiController::class, 'index'])->name('api.v1.posts.index');
    Route::get('/posts/{slug}', [PostApiController::class, 'show'])->name('api.v1.posts.show');

    // --- Páginas (público) ---
    Route::get('/pages', [PageApiController::class, 'index'])->name('api.v1.pages.index');
    Route::get('/pages/{slug}', [PageApiController::class, 'show'])->name('api.v1.pages.show');

    // --- Categorías (público) ---
    Route::get('/categories', [CategoryApiController::class, 'index'])->name('api.v1.categories.index');
    Route::get('/categories/{slug}', [CategoryApiController::class, 'show'])->name('api.v1.categories.show');

    // --- Tokens de API (autenticado) ---
    Route::middleware('auth:sanctum')->prefix('user/tokens')->group(function () {
        Route::get('/', [TokenController::class, 'index'])->name('api.v1.tokens.index');
        Route::post('/', [TokenController::class, 'store'])->name('api.v1.tokens.store');
        Route::delete('/{tokenId}', [TokenController::class, 'destroy'])->name('api.v1.tokens.destroy');
    });
});
