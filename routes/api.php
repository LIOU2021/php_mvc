<?php

use App\Controllers\TestController;
use App\Controllers\UserController;
use App\Http\Route;

Route::prefix('user')->group(function(){
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'create']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::delete('/{id}', [UserController::class, 'delete']);
    Route::put('/{id}', [UserController::class, 'update']);
});

Route::prefix('test')->middleware(['test','auth'])->group(function(){
    Route::get('/', [TestController::class, 'index']);
    Route::get('/{id}', [TestController::class, 'index']);
    Route::post('/', [TestController::class, 'index']);
    Route::delete('/{id}', [TestController::class, 'index']);
    Route::put('/{id}', [TestController::class, 'index']);
});