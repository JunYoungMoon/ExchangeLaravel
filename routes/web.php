<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Storage;

// Auth Routes
require __DIR__ . '/auth.php';

// 화면부분
Route::get('/', function () {
    return view('welcome');
});

Route::get('/exchange',\App\Livewire\exchange\Index::class)->name('exchange.index');
Route::get('/articles', \App\Livewire\articles\Index::class);

Route::get('/articles/detail/{article}' /*{article}은 Article 모델 바인딩*/, function (Article $article) {
    return view('articles.detail', ['article' => $article]);
})->name('articles.detail');

Route::middleware('auth')->group(function () {
    Route::get('/articles/edit/{article}', function (Request $request, Article $article) {
//        Gate::authorize('update', $article);
//        Auth::user(); 혹은 Request::user()

        if (Auth::user()->cannot('update', $article)) {
            abort(403);
        }

        return view('articles.edit', ['article' => $article]);
    })->name('articles.edit')->middleware('login.expiry');

    Route::get('/articles/create', function () {
        return view('articles.create');
    })->name('articles.create')->middleware('login.expiry');
});

// 기능부분
// 그룹화 [ArticlesController::class] 생략 가능
Route::controller(ArticlesController::class)->group(function (){
    Route::post('/api/articles/list', 'list')->name('api.articles.list');
    Route::post('/api/articles/create', 'create')->name('api.articles.create')->middleware(['auth','login.expiry']);
    //put 전체수정, patch 일부수정
    Route::patch('/api/articles/{article}', 'update')->name('api.articles.update')->middleware(['auth','login.expiry']);
    Route::delete('/api/articles/{article}', 'delete')->name('api.articles.delete')->middleware(['auth','login.expiry']);
});

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/api/register', [RegisterController::class, 'register'])->name('api.register');

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Route::get('/charting_library/{filename}', function ($filename) {
//    $path = Storage::disk('public')->path('charting_library/' . $filename);
//
//    if (!Storage::disk('public')->exists('charting_library/' . $filename)) {
//        abort(404);
//    }
//
//    return response()->file($path);
//});
//
//Route::get('/datafeeds/udf/dist/{filename}', function ($filename) {
//    $path = Storage::disk('public')->path('datafeeds/udf/dist/' . $filename);
//
//    if (!Storage::disk('public')->exists('datafeeds/udf/dist/' . $filename)) {
//        abort(404);
//    }
//
//    return response()->file($path);
//});

