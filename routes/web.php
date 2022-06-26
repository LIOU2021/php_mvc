<?php

use App\Controllers\WelcomeController;
use App\Http\Route;

Route::get('/',[WelcomeController::class,"index"]);
Route::post('/',[WelcomeController::class,"index"]);
Route::delete('/',[WelcomeController::class,"index"]);
Route::put('/',[WelcomeController::class,"index"]);