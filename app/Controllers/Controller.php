<?php

namespace App\Controllers;

use App\Http\Http;

class Controller
{

    /**
     * API所能接受的方法。預設是全部。
     */
    protected $action = ["*"];

    /**
     * Get request accept method
     * 
     * @return array
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * 限制特定請求API格式執行的內容
     * 
     * @param string $method 請求方法
     * @param boolean $urlParam 是否接受url參數
     * @param callable $callback 
     */
    public function limitAPI(string $method, bool $urlParam = false, callable $callback)
    {
        $http = new Http();
        return $http->accept($method, $urlParam, $callback);
    }
}
