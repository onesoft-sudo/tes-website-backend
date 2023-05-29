<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\BearerTokenAuth;
use App\Http\Middleware\SuperAdminAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'index']);

Route::prefix('/api')->group(function () {
    Route::middleware(SuperAdminAuth::class)->group(function () {
        Route::apiResource('users', UserController::class);
    });

    Route::middleware(BearerTokenAuth::class)->group(function () {
        Route::apiResource('threads', ThreadController::class, [
            'except' => ['index', 'show']
        ]);
    });

    Route::apiResource('threads', ThreadController::class, [
        'only' => ['index', 'show']
    ]);
});
