<?php

namespace App\Http;

class Route
{

    public static $apiPrefixFile = true;
    private static array $middleware = [];

    public static function get($url, $controllerArr)
    {
        self::add($url, "GET", $controllerArr);
    }

    public static function post($url, $controllerArr)
    {
        self::add($url, "POST", $controllerArr);
    }

    public static function put($url, $controllerArr)
    {
        self::add($url, "PUT", $controllerArr);
    }

    public static function delete($url, $controllerArr)
    {
        self::add($url, "DELETE", $controllerArr);
    }

    public static function add($url, $method, $controllerArr)
    {
        $urlParamCondition = false;

        if (strpos($url, '{') && strpos($url, '}')) {
            $urlParamCondition = true;
        }

        if (self::$apiPrefixFile) {
            $url = "/api$url";
        }

        if ($urlParamCondition) {
            $routerAddCondition = false;

            $uriArr = explode("/", $url);
            array_pop($uriArr);
            $addUri = implode("/", $uriArr);

            if (isset($GLOBALS['router'][$method])) {
                $urlObj = $GLOBALS['router'][$method];
                $urlKeysObj = array_keys($urlObj);
                foreach ($urlKeysObj as $index => $item) {
                    if (strpos($item, '{') && strpos($item, '}')) {
                        $itemArr = explode("/", $item);
                        array_pop($itemArr);
                        $existsUri = implode("/", $itemArr);
                        if ($addUri == $existsUri) {
                            $routerAddCondition = true;
                        }
                    }
                }
            }
        } else {
            $routerAddCondition = isset($GLOBALS['router'][$method][$url]);
        }

        if ($routerAddCondition) {
            helpReturn(407, $url . "@" . $method);
        } else {
            if (count(self::getMiddleware())) {
                $GLOBALS['router'][$method][$url] = [
                    'middleware' => self::getMiddleware(),
                    'middlewareGroups' => self::getMiddlewareGroups(self::$apiPrefixFile),
                    'controllerName' => $controllerArr[0],
                    'controllerMethod' => $controllerArr[1],
                    'urlParamCondition' => $urlParamCondition,
                ];
                self::setMiddleware([]);
            } else {
                $GLOBALS['router'][$method][$url] = [
                    'middleware' => [],
                    'middlewareGroups' => self::getMiddlewareGroups(self::$apiPrefixFile),
                    'controllerName' => $controllerArr[0],
                    'controllerMethod' => $controllerArr[1],
                    'urlParamCondition' => $urlParamCondition,
                ];
            }
        }
    }

    public static function middleware(array $middleware)
    {
        $route = new Route();
        return $route->setMiddleware($middleware);
    }

    public static function setMiddleware(array $middleware)
    {
        self::$middleware = $middleware;
        return new self;
    }

    public static function getMiddleware()
    {
        return self::$middleware;
    }

    public static function getMiddlewareGroups($isApi)
    {
        $kernel = new Kernel();
        $middlewareGroups = [];
        
        $group = "";

        if ($isApi) {
            $middlewareGroups = $kernel->getMiddlewareGroups()['api'];
            $group="api";
        } else {
            $middlewareGroups = $kernel->getMiddlewareGroups()['web'];
            $group="web";
        }

        if (count($middlewareGroups)) {
            foreach ($middlewareGroups as $middlewareGroup) {
                if (!class_exists($middlewareGroup)) {
                    helpReturn(704, "check $group middleware group : $middlewareGroup");
                }
            }
        }

        return $middlewareGroups;
    }
}
