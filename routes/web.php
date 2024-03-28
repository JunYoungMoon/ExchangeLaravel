<?php

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\View\RegisterViewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterViewController::class, 'showRegistrationForm'])->name('view.register');
Route::post('/api/register', [RegisterController::class, 'register']);
