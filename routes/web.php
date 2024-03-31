<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;

// Auth Routes
require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/articles', function (){
    $articles = Article::all();
    return view('articles.index', ['articles' => $articles]);
});
Route::get('/articles/create', function (){
    return view('articles.create');
});

Route::post('/api/articles/create', [ArticlesController::class, 'create'])->name('api.articles.create');

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/api/register', [RegisterController::class, 'register'])->name('api.register');
