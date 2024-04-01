<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Auth Routes
require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/articles', function (){ return view('articles.index'); });
Route::post('/api/articles/list', [ArticlesController::class, 'list'])->name('api.articles.list');

Route::get('/articles/create', function (){ return view('articles.create'); });
Route::post('/api/articles/create', [ArticlesController::class, 'create'])->name('api.articles.create');

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/api/register', [RegisterController::class, 'register'])->name('api.register');
