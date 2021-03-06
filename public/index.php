<?php

declare(strict_types=1);

require_once '../config/cors.php';

use App\Providers\AppProvider;

require_once '../vendor/autoload.php';

AppProvider::register();

require_once '../config/app.php';

date_default_timezone_set(TIMEZOME);

require_once '../config/error.php';
require_once '../bootstrap/app.php';

