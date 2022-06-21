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
