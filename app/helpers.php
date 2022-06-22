<?php

if (!function_exists('test')) {
    function test()
    {
        echo time() . '_test';
    }
}

if (!function_exists('helpReturn')) {

    /**
     * response message
     * 
     * @param int $status code like 404
     * @param mix $data what you want to response
     * 
     */
    function helpReturn($status, $data = null)
    {
        header('Content-Type: application/json; charset=utf-8');
        $code = require_once('../config/code.php');
        $res['status'] = $status;
        $res['msg'] = $code[$status];
        $res['data'] = $data;
        return json_encode($res);
    }
}

if (!function_exists('env')) {

    /**
     * get env data
     * 
     * @param string $key env的key
     * @param mix $default 如果找不到該key，欲返回的值
     */
    function env($key, $default = null)
    {
        if (isset($GLOBALS['envArr'][$key])) {
            return $GLOBALS['envArr'][$key];
        } else {
            return $default;
        }
    }
}
