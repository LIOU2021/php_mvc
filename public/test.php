<?php

require_once '../vendor/autoload.php';

use App\Controllers\UserController;
use App\Models\User;
use App\Providers\AppProvider;

AppProvider::register();
// var_dump($envArr);

var_dump(env('SITENAME',null));
echo "<br>";

// $classPath = sprintf('App\Controllers\%s', "UserController");
// $class = new $classPath;
// $class->index();

// $test = new UserController();
// $test->index();

// $user = new User();
// $user->all();
// echo 'test123';
