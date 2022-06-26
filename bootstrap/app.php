<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch (ROUTERSTYLE) {
    case 'thinkphp':
        thinkphpStyle($uri);
        break;
    case 'laravel':
        laravelStyle($uri);
        break;
    default:
        helpReturn(400, "your router style : " . ROUTERSTYLE);
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
    // echo json_encode($GLOBALS['router'],JSON_PRETTY_PRINT);
    // exit;

    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $uriArr = explode("/", $uri);
    $uriLn = count($uriArr);
    $urlParam = $uriArr[$uriLn - 1];
    // dd(is_numeric($urlParam));

    if (is_numeric($urlParam)) {
        array_pop($uriArr);
        $uri = implode("/", $uriArr);
        $routerCondition = isset($GLOBALS['router'][$requestMethod]);
        // dd($requestMethod);
        // echo json_encode($GLOBALS['router'],JSON_PRETTY_PRINT);
        // exit;

        // dd($routerCondition);

        if ($routerCondition) {
            $routerCondition = false;
            $urlParamObj = $GLOBALS['router'][$requestMethod];
            $urlParamKeysArr = array_keys($urlParamObj);
            foreach ($urlParamKeysArr as $index => $item) {
                if (strpos($item, '{') && strpos($item, '}')) {
                    $existsUrlPathArr = explode("/", $item);
                    array_pop($existsUrlPathArr);
                    $existsUrlPath = implode("/", $existsUrlPathArr);
                    // dd($existsUrlPath,$uri);
                    if ($existsUrlPath == $uri) {
                        $routerCondition = true;
                        $uri = $item;
                        runMiddleware($item, $requestMethod);
                    }
                }
            }
        }
    } else {
        $routerCondition = isset($GLOBALS['router'][$requestMethod]) && isset($GLOBALS['router'][$requestMethod][$uri]);

        // dd(
        //     $uri,
        //     $requestMethod,
        // );

        if ($routerCondition) {
            runMiddleware($uri, $requestMethod);
        }
    }

    if ($routerCondition) {
        $routerOjb = $GLOBALS['router'][$requestMethod][$uri];
        $controllerName = $routerOjb['controllerName'];
        $controllerMethod = $routerOjb['controllerMethod'];

        // dd($controllerName, $controllerMethod);

        callClassForlaravel($controllerName, $controllerMethod);

        echo json_encode($GLOBALS['router'], JSON_PRETTY_PRINT);
    } else {
        if (is_numeric($urlParam)) {
            // dd($uri);

            foreach ($GLOBALS['router'] as $methods => $item) {
                if (isset($GLOBALS['router'][$methods])) {
                    $urlKeys = array_keys($GLOBALS['router'][$methods]);
                    // dd($methods,$urlKeys);
                    foreach ($urlKeys as $item2) {
                        if (strpos($item2, "{") && strpos($item2, "}")) {
                            $item2Arr = explode("/", $item2);
                            array_pop($item2Arr);
                            $item2String = implode("/", $item2Arr);
                            if ($item2String == $uri) {
                                // dd($methods,$urlKeys);
                                // echo json_encode($GLOBALS['router'],JSON_PRETTY_PRINT);
                                helpReturn(403, "your methods:" . $requestMethod . ". only allow $methods of method !");
                            }
                        }
                    }
                }
            }

            helpReturn(404, $uri . "/{id}" . "@" . $requestMethod);
        } else {
            foreach ($GLOBALS['router'] as $methods => $item) {
                if (isset($item[$uri])) {
                    helpReturn(403, "your methods:" . $requestMethod . ". only allow $methods of method !");
                }
            }

            helpReturn(404, $uri . "@" . $requestMethod);
        }
    }
}


/**
 * Router處理-laravel
 * 
 * @param string $controllerName name of controller
 * @param string $controllerMethod method of controller
 */
function callClassForlaravel($controllerName, $controllerMethod)
{
    $filePath = str_replace("\\", "/", $controllerName);
    $filePath = "../" . str_replace("App", "app", $filePath) . ".php";

    if (!file_exists($filePath)) {
        helpReturn(401, "file $filePath not find !");
    } else {

        $class = new ReflectionClass($controllerName);

        if ($class->hasMethod("__construct")) {
            $parameters = $class->getMethod("__construct")->getParameters();
        } else {
            $parameters = [];
        }


        if (!count($parameters)) {
            $instance = $class->newInstance();
            $controller = $instance;
        } else {

            if (!DI) {
                helpReturn(410, "check : $controllerName");
            }

            foreach ($parameters as $parameter) {
                $argType = (string)$parameter->getType()->getName();

                if (!checkNeedDI($argType)) {
                    helpReturn(412, $controllerName . ' - find construct arg type : ' . $argType);
                }

                $instanceReflection = new ReflectionClass($argType);

                if ($instanceReflection->hasMethod("__construct") && count($instanceReflection->getMethod("__construct")->getParameters())) {
                    helpReturn(410, 'check : ' . $argType);
                } else {
                    $instance[] = $instanceReflection->newInstance();
                }
            }
            $controller = $class->newInstance(...$instance);
        };



        if (!method_exists($controller, $controllerMethod)) {
            helpReturn(402, "$controllerMethod of method not defind in $controllerName");
        } else {
            // dd($controllerName,$controllerMethod);
            if (DI) {
                helpReturn(200, callDI($controllerName, $controllerMethod, $controller));
            } else {
                if (!count($class->getMethod($controllerMethod)->getParameters())) {
                    helpReturn(200, $controller->$controllerMethod());
                } else {
                    helpReturn(411, "check " . $controllerName . "@" . $controllerMethod);
                };
            }
        }
    }
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
    $uri[1][0] = strtoupper($uri[1][0]);

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

/**
 * run DI for router
 */
function callDI(string $controller, string $method, $controllerInstance)
{
    $classMethod = new ReflectionMethod($controller, $method);
    $parameters = $classMethod->getParameters();

    $counter = 0;
    $diArr = [];
    if (count($parameters)) {
        foreach ($parameters as $parameter) {

            $dependenceClass = (string) $parameter->getType()->getName();

            $need = checkNeedDI($dependenceClass);
            if (!$counter && $need) {
                $class = new ReflectionClass($dependenceClass);
                if (!$class->hasMethod("__construct") || (!count($class->getMethod("__construct")->getParameters()))) {
                    $instance = $class->newInstance();
                } else {
                    helpReturn(410, 'check : ' . $dependenceClass);
                };

                $diArr[] = $instance;
            } else {
                if ($need) {
                    $class = new ReflectionClass($dependenceClass);

                    if (!$class->hasMethod("__construct") || (!count($class->getMethod("__construct")->getParameters()))) {
                        $instance = $class->newInstance();
                    } else {
                        helpReturn(410, 'check : ' . $dependenceClass);
                    };

                    $diArr[] = $instance;
                } else {
                    helpReturn(409, "method: $method." . " your arg type find : " . $dependenceClass);
                }
            }

            if ($counter > 1 && !$need) {
                helpReturn(409, "method: $method." . " your arg type find : " . $dependenceClass);
            }

            $counter++;
        }

        return $controllerInstance->$method(...$diArr);
    } else {
        return $controllerInstance->$method();
    }
}

/**
 * check dataType can be DI
 */
function checkNeedDI(string $type)
{
    if (strpos($type, "\\")) {
        return true;
        // return "use DI : " . $type;
    } else {
        return false;
        // return "don't use DI : " . $type;
    }
}

/**
 * run middleware 
 */
function runMiddleware($uri, $method)
{
    $router = $GLOBALS['router'][$method][$uri];

    if (count($router['middlewareGroups'])) {
        //run middleware
        foreach ($router['middlewareGroups'] as $middlewareGroup) {
            $middlewareGropClass = new ReflectionClass($middlewareGroup);
            $middlewareGropInstance = $middlewareGropClass->newInstance();
            $middlewareGropInstance->run();
        }
    };

    if (count($router['middleware'])) {
        //run middleware
        $kernelClass = new ReflectionClass("App\\Http\\Kernel");
        $kernelInstance = $kernelClass->newInstance();
        $routerMiddleware = $kernelInstance->getRouteMiddleware();
        foreach ($router['middleware'] as $item) {
            if (isset($routerMiddleware[$item])) {
                $middlewareClassName = $routerMiddleware[$item];
                if (class_exists($middlewareClassName)) {
                    $middlewareClass = new ReflectionClass($middlewareClassName);
                    $middlewareInstance = $middlewareClass->newInstance();
                    // dd($middlewareInstance->run());
                    $middlewareInstance->run();
                    // dd('middleware run不停 !');
                } else {
                    helpReturn(701, $middlewareClassName);
                }
            } else {
                helpReturn(700, "not find : " . $item);
            };
        }
    };
}
