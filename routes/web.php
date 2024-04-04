<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;

// 화면부분
Route::get('/', function () {
    return view('welcome');
});
Route::get('/articles', function () {
    return view('articles.index');
})->name('articles.index');

Route::get('/articles/detail/{article}' /*{article}은 Article 모델 바인딩*/, function (Article $article) {
    return view('articles.detail', ['article' => $article]);
})->name('articles.detail');

Route::get('/articles/edit/{article}', function (Article $article) {
    return view('articles.edit', ['article' => $article]);
})->name('articles.edit');

Route::get('/articles/create', function () {
    return view('articles.create');
})->name('articles.create');

// 기능부분
// 그룹화 [ArticlesController::class] 생략 가능
Route::controller(ArticlesController::class)->group(function (){
    Route::post('/api/articles/list', 'list')->name('api.articles.list');
    Route::post('/api/articles/create', 'create')->name('api.articles.create');
    //put 전체수정, patch 일부수정
    Route::patch('/api/articles/{article}', 'update')->name('api.articles.update');
    Route::delete('/api/articles/{article}', 'delete')->name('api.articles.delete');
});

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/api/register', [RegisterController::class, 'register'])->name('api.register');

// Auth Routes
require __DIR__ . '/auth.php';
