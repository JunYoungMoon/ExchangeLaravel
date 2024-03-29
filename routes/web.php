<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Auth Routes
require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/api/register', [RegisterController::class, 'register'])->name('api.register');
