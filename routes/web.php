<?php

use App\Controllers\WelcomeController;
use App\Http\Route;

Route::get('/',[WelcomeController::class,"index"]);