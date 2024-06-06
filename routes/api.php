<?php

use App\Actions\Auth\LoginAction;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ExchangeController;
use Illuminate\Support\Facades\Route;

//Route::group([
//    'middleware' => 'api',
//    'prefix' => 'auth'
//], function () {
//    Route::post('login', [AuthController::class, 'login']);
//    Route::post('logout', [AuthController::class, 'logout']);
//    Route::post('refresh', [AuthController::class, 'refresh']);
//    Route::post('me', [AuthController::class, 'me']);
//});

Route::group([
    'middleware' => ['api.response'],
], function () {

    Route::group([
        'prefix' => 'auth'
    ], function () {
        Route::post('login', [LoginAction::class, 'handle']);
        Route::middleware(['auth:sanctum'])->post('logout', [AuthController::class, 'logout']);
    });

    Route::group([
        'prefix' => 'exchange'
    ], function () {
        Route::middleware(['auth:sanctum'])->post('trade', [ExchangeController::class, 'trade'])
            ->middleware('throttle:60,1'); // 1분당 60회 요청 제한
    });
});



