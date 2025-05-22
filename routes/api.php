<?php

use App\Http\Controllers\API\v1\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('user')->group(function () {
        Route::controller(AuthController::class)->prefix('auth')->group(function () {
            Route::post('register', 'register');
            Route::post('login', 'loginOne');
            Route::post('logout', 'logout');
        });

        Route::middleware(['auth:sanctum'])->get('/', function (Request $request) {
            return $request->user();
        });
    });
});
