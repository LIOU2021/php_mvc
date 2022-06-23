<?php

use App\Controllers\UserController;
use App\Http\Route;

Route::get('/user',[UserController::class,'index']);
Route::post('/user',[UserController::class,'create']);
Route::get('/user/{id}',[UserController::class,'show']);
Route::delete('/user/{id}',[UserController::class,'delete']);
Route::put('/user',[UserController::class,'update']);
