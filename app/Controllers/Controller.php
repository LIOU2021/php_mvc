<?php

namespace App\Controllers;

use App\Http\Http;

class Controller
{

    /**
     * 該Controller所支持的request methods
     * 
     * 如果無特別覆寫，那麼將會支持全部的request methods
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

    /**
     * 檢測limitAPI回傳非null時就要回傳
     */
    public function allowAPI(array $arr)
    {
        $trueCount = 0;
        $res = null;

        foreach ($arr as $item) {
            if ($item) {
                $trueCount++;
                $res = $item;
            }
        }

        if ($trueCount >= 2) {
            helpReturn(405);
        }else if($trueCount == 0){
            helpReturn(406);
        } else {
            return $res;
        }
    }

    /**
     * 獲得url路徑最後一個值
     */
    public function getUrlParam(){
        return (new Http())->getUrlParam();
    }
}
