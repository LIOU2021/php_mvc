<?php

namespace App\Controllers;

use App\Http\Http;

class Controller
{

    private $http;

    /**
     * 該Controller所支持的request methods
     * 
     * 如果無特別覆寫，那麼將會支持全部的request methods
     */
    protected $action = ["*"];

    public function __construct()
    {
        $this->http = new Http();
    }

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
        $http = $this->http;
        return $http->accept($method, $urlParam, $callback);
    }
}
