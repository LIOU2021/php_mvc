<?php

use App\Controllers\UserController;
use App\Http\Route;

Route::get('/user',[UserController::class,'index']);
Route::get('/user/{id}',[UserController::class,'show']);