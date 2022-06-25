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
                    'controllerName' => $controllerArr[0],
                    'controllerMethod' => $controllerArr[1],
                    'urlParamCondition' => $urlParamCondition,
                ];
            } else {
                $GLOBALS['router'][$method][$url] = [
                    'middleware' => [],
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

    public function setMiddleware(array $middleware)
    {
        self::$middleware = $middleware;
        return $this;
    }

    public static function getMiddleware()
    {
        return self::$middleware;
    }
}
