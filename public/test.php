<?php

require_once '../vendor/autoload.php';

use App\Controllers\UserController;
use App\Models\User;

class Foo
{
    public static $my_static = 'foo';

    public function staticValue() {
        return self::$my_static;
    }
}

$classPath = sprintf('App\Controllers\%s', "UserController");
$class = new $classPath;
$class->index();

$test = new UserController();
$test->index();

// $user = new User();
// $user->all();
echo 'test123';
