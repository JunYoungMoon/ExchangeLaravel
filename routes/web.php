<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Auth Routes
require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/articles/create', [ArticlesController::class, 'index']);
Route::post('/api/articles/create', [ArticlesController::class, 'create'])->name('api.articles.create');

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/api/register', [RegisterController::class, 'register'])->name('api.register');
