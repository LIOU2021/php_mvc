<?php

use App\Controllers\UserController;
use App\Http\Route;

Route::get('/user/{id}',[UserController::class,'show']);
Route::get('/user',[UserController::class,'index']);
Route::put('/user',[UserController::class,'update']);
Route::post('/user',[UserController::class,'create']);