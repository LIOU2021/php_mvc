<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch (ROUTERSTYLE) {
    case 'thinkphp':
        thinkphpStyle($uri);
        break;
    case 'laravel':
        laravelStyle($uri);
        break;
}

/**
 * Router模式-laravel
 */
function laravelStyle($uri)
{
    require_once '../routes/api.php';
    $reflectionClass = new ReflectionClass('App\Http\Route');
    $reflectionClass->getProperty('apiPrefixFile')->setValue(false);
    require_once '../routes/web.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if (isset($GLOBALS['router'][$requestMethod]) && isset($GLOBALS['router'][$requestMethod][$uri])) {
    } else {
        foreach ($GLOBALS['router'] as $methods => $item) {
            if (isset($item[$uri])) {
                helpReturn(403, "your methods:" . $requestMethod);
            }
        }
        helpReturn(404, $uri . "@" . $requestMethod);
    }
    $routerOjb = $GLOBALS['router'][$requestMethod][$uri];
    $controllerName = $routerOjb['controllerName'];
    $controllerMethod = $routerOjb['controllerMethod'];
    // dd($controllerName,$controllerMethod);
    callClassForlaravel($controllerName, $controllerMethod);
    // dd($GLOBALS['router']);

    echo json_encode($GLOBALS['router'], JSON_PRETTY_PRINT);
}


/**
 * Router處理-laravel
 * 
 * @param array $uri route path
 * @param string $method
 */
function callClassForlaravel($controllerName, $controllerMethod, $uri = null, $method = null)
{
    $filePath = str_replace("\\", "/", $controllerName);
    $filePath = str_replace("App", "app", $filePath)."php";

    if (!file_exists($filePath)) {
        helpReturn(401, "file $filePath not find !");
    }else{
        dd('成功');
        //check method exists and run method
    }

    // if (!file_exists($filePath)) {
    //     helpReturn(401, "file app/Controllers/$uri[1]Controller.php not find !");
    // } else {
    //     include_once($filePath);

    //     $controllerName = "$uri[1]Controller";

    //     $controllerPath = sprintf('App\Controllers\%s', $controllerName);
    //     $controller = new $controllerPath();

    //     $actionArray = $controller->getAction();

    //     if (!in_array("*", $actionArray)) {
    //         $requestMethod = $_SERVER['REQUEST_METHOD'];
    //         if (!in_array($requestMethod, $actionArray)) {
    //             helpReturn(403, "request method now : $requestMethod");
    //         }
    //     }

    //     if ($method == null) {
    //         $method = $uri[2];
    //     }

    //     if (!method_exists($controller, $method)) {
    //         helpReturn(402, "$method of method not find in $controllerName");
    //     } else {
    //         helpReturn(200, $controller->$method());
    //     }
    // }
}


/**
 * Router模式-thinkphp
 */
function thinkphpStyle($uri)
{
    $uri = explode('/', $uri);
    $ln = count($uri);

    if (is_numeric($uri[$ln - 1])) {
        $ln -= 1;
    };

    switch (true) {
        case ($ln <= 2):
            if (!$uri[1]) {
                echo 'Welcome !';
                exit();
            } else {
                callClassForThinkphp($uri, "index");
            }
            break;
        case ($ln == 3):
            callClassForThinkphp($uri);
            break;
    }
}


/**
 * Router處理-thinkphp
 * 
 * @param array $uri route path
 * @param string $method
 */
function callClassForThinkphp($uri, $method = null)
{

    $filePath = "../app/Controllers/$uri[1]Controller.php";

    if (!file_exists($filePath)) {
        helpReturn(401, "file app/Controllers/$uri[1]Controller.php not find !");
    } else {
        include_once($filePath);

        $controllerName = "$uri[1]Controller";

        $controllerPath = sprintf('App\Controllers\%s', $controllerName);
        $controller = new $controllerPath();

        $actionArray = $controller->getAction();

        if (!in_array("*", $actionArray)) {
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            if (!in_array($requestMethod, $actionArray)) {
                helpReturn(403, "request method now : $requestMethod");
            }
        }

        if ($method == null) {
            $method = $uri[2];
        }

        if (!method_exists($controller, $method)) {
            helpReturn(402, "$method of method not find in $controllerName");
        } else {
            helpReturn(200, $controller->$method());
        }
    }
}
