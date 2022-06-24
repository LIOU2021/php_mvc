<?php

use App\Controllers\TestController;
use App\Controllers\UserController;
use App\Http\Route;

Route::get('/user',[UserController::class,'index']);
Route::post('/user',[UserController::class,'create']);
Route::get('/user/{id}',[UserController::class,'show2']);
Route::delete('/user/{id}',[UserController::class,'delete']);
Route::put('/user/{id}',[UserController::class,'update']);

Route::get('/test',[TestController::class,'index']);
