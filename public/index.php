<?php

require_once '../vendor/autoload.php';
require_once '../config/app.php';
require_once '../bootstrap/app.php';

use App\Models\User;
use App\Repository\UserRepository;

User::all();
echo "<br>";
test();
$userRepo = new UserRepository();
echo "<br>";
$userRepo->index();
echo "<br>";
echo DB_HOST;
echo "<br>";

return null;
