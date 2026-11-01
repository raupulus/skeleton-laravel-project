<?php

use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LanguageController;
use App\Http\Controllers\Web\LogDownloadController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\PostController;
use App\Http\Controllers\Web\StaticPageController;
use Illuminate\Support\Facades\Route;

// --- Página principal ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- Blog ---
Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('blog.show');

// --- Páginas dinámicas ---
Route::get('/pages/{slug}', [PageController::class, 'show'])->name('pages.show');

// --- Contacto ---
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])
    ->middleware('throttle:10,1')
    ->name('contact.send');

// --- Páginas estáticas ---
Route::get('/about', [StaticPageController::class, 'about'])->name('about');
Route::get('/privacy', [StaticPageController::class, 'privacy'])->name('privacy');
Route::get('/cookies', [StaticPageController::class, 'cookies'])->name('cookies');

// --- Cambio de idioma ---
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// --- Descarga de logs (solo admin) ---
Route::get('/admin/logs/download/{filename}', [LogDownloadController::class, 'download'])
    ->middleware(['auth'])
    ->name('admin.logs.download');

// --- Autenticación (Breeze) ---
require __DIR__.'/auth.php';
