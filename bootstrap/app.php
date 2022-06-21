<?php

use App\Controllers\UserController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$ln = count($uri);

switch (true) {
    case ($ln <= 2):
        if (!$uri[1]) {
            echo 'Welcome !';
            exit();
        } else {
            callClass($uri, "index");
        }
        break;
    case ($ln == 3):
        callClass($uri);
        break;
}

function callClass($uri, $method = null)
{
    
    $filePath = "../app/Controllers/$uri[1]Controller.php";

    if (!file_exists($filePath)) {
        header("HTTP/1.1 404 Not Found");
        echo helpReturn(401, "file app/Controllers/$uri[1]Controller.php not find !");
        exit();
    } else {
        include_once($filePath);

        $controllerName = "$uri[1]Controller";

        $controllerPath = sprintf('App\Controllers\%s', $controllerName);
        $controller = new $controllerPath();

        if ($method == null) {
            $method = $uri[2];
        }
        
        if (!method_exists($controller, $method)) {
            header("HTTP/1.1 404 Not Found");
            echo helpReturn(402, "$method of method not find in $controllerName");
            exit();
        } else {
            echo helpReturn(200, $controller->$method());
            exit();
        }
    }
}
