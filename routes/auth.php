<?php

use Illuminate\Support\Facades\Route;

Route::get('login', [AuthenticatedSessionController::class, 'index']);
Route::post('login', [AuthenticatedSessionController::class, 'store']);
