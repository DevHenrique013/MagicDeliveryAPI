<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ForceJSON;

Route::group(["prefix" => "v1"], function () {
    Route::middleware(ForceJSON::class)->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('/login', [AuthController::class, 'login']);

            Route::middleware('auth:sanctum')->group(function () {
                Route::get('/me', [AuthController::class, 'me']);
                Route::post('/logout', [AuthController::class, 'logout']);
            });
        });
        Route::prefix('users')->group(function () {
            Route::post('/', [UserController::class, 'store']);
            Route::get('/', [UserController::class, 'index']);
            Route::middleware('auth:sanctum')->group(function () {
                Route::patch('/balance/increase', [UserController::class, 'increaseBalance']);
                Route::patch('/balance/decrease', [UserController::class, 'decreaseBalance']);
            });
        });
    });
    Route::get('teste', function(){
        return response()->json([
            'message' => 'tudo okay',
        ], 200);
    });
});
