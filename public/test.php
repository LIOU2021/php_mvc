<?php

require_once '../vendor/autoload.php';

use App\Models\User;

echo (new User())->getModelName();