<?php

use App\Controllers\TestController;
use App\Controllers\WelcomeController;
use App\Http\Route;

Route::get('/',[WelcomeController::class,"index"]);
Route::post('/',[WelcomeController::class,"index"]);
Route::delete('/',[WelcomeController::class,"index"]);
Route::put('/',[WelcomeController::class,"index"]);

Route::prefix('world')->group(function(){
    Route::get('/test',[TestController::class,"index"]);
    Route::get('/test/{id}',[TestController::class,"index"]);
    Route::post('/test',[WelcomeController::class,"index"]);
    Route::delete('/test',[WelcomeController::class,"index"]);
    Route::put('/test',[WelcomeController::class,"index"]);
});

Route::prefix('world')->group(function(){
    Route::get('/',[TestController::class,"index"]);
    Route::get('/{id}',[TestController::class,"index"]);
    Route::post('/',[WelcomeController::class,"index"]);
    Route::delete('/{id}',[WelcomeController::class,"index"]);
    Route::put('/{id}',[WelcomeController::class,"index"]);
});
