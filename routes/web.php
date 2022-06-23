<?php

use App\Controllers\UserController;
use App\Http\Route;

Route::get('/user',[UserController::class,'index']);
Route::put('/user',[UserController::class,'update']);
Route::post('/user',[UserController::class,'create']);
Route::post('/user/create',[UserController::class,'create']);
Route::get('/user/{id}',[UserController::class,'show']);