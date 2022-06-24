<?php
//DI模式
define('DI', env('DI',false));

//debug模式
define('debug', env('debug',false));

// 網站名稱
define('SITENAME', env('SITENAME',"自製 php mvc"));

// Database 的參數，以下為範例
define('DATABASE', env('DATABASE',null));
define('DB_HOST', env('DB_HOST',null));
define('DB_PORT', env('DB_PORT',null));
define('DB_NAME', env('DB_NAME',null));
define('DB_USER', env('DB_USER',null));
define('DB_PASS', env('DB_PASS',null));

//router
define('ROUTERSTYLE',env('ROUTERSTYLE','thinkphp'));

