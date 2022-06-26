<?php

use App\Controllers\TestController;
use App\Controllers\UserController;
use App\Http\Route;

Route::get('/user', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'create']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::delete('/user/{id}', [UserController::class, 'delete']);
Route::put('/user/{id}', [UserController::class, 'update']);

Route::middleware(['auth','test'])->get('/test/{id}', [TestController::class, 'show']);
Route::middleware(['auth','test'])->post('/test/{id}', [TestController::class, 'show']);
Route::middleware(['auth','test'])->delete('/test/{id}', [TestController::class, 'show']);
Route::middleware(['auth','test'])->put('/test/{id}', [TestController::class, 'show']);

// Route::middleware(['auth','test'])->get('/test', [TestController::class, 'show']);
Route::middleware(['test'])->get('/test', [TestController::class, 'index']);
Route::middleware(['test'])->post('/test', [TestController::class, 'index']);
Route::middleware(['test'])->put('/test', [TestController::class, 'index']);
Route::middleware(['test'])->delete('/test', [TestController::class, 'index']);

Route::middleware(['test'])->get('/test3', [TestController::class, 'index']);
Route::middleware(['test'])->post('/test3', [TestController::class, 'index']);
Route::middleware(['test'])->put('/test3', [TestController::class, 'index']);
Route::middleware(['test'])->delete('/test3', [TestController::class, 'index']);

Route::middleware(['test'])->get('/test4/{id}', [TestController::class, 'index']);
Route::middleware(['test'])->post('/test4/{id}', [TestController::class, 'index']);
Route::middleware(['test'])->put('/test4/{id}', [TestController::class, 'index']);
Route::middleware(['test'])->delete('/test4/{id}', [TestController::class, 'index']);

// Route::get('/test', [TestController::class, 'index']);
// Route::delete('/test', [TestController::class, 'index']);
// Route::get('/test/{id}', [TestController::class, 'show']);
