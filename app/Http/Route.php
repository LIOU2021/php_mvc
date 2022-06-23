<?php

namespace App\Http;

class Route
{

    public static $apiPrefixFile = true;

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
        self::add($url, "delete", $controllerArr);
    }

    public static function add($url, $method, $controllerArr)
    {
        if (self::$apiPrefixFile) {
            $url = "/api$url";
        }

        if (
            isset($GLOBALS['router'][$method][$url])
            ) {
            helpReturn(407,$url."@".$method);
        } else {
            $GLOBALS['router'][$method][$url]= [
                    'middleware' => null,
                    'controllerName' => $controllerArr[0],
                    'controllerMethod' => $controllerArr[1],
            ];
        }
    }
}
