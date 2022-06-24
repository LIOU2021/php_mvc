<?php

namespace App\Http;

class Request
{

    private $methods;
    private $uri;
    private $uriLn;
    private $urlParam;
    public $params;

    public function __construct()
    {
        $this->methods = $_SERVER['REQUEST_METHOD'];
        $this->uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $this->uriLn = count($this->uri);
        $this->urlParam = $this->uri[$this->uriLn - 1];

        foreach ($_REQUEST as $index => $item) {
            $this->params[$index] = $item;
        }
    }

    public function __get($property)
    {
        if (in_array($property, array_keys(getClassProperties(Request::class, 'private')))) {
            helpReturn(601, $property);
        } else {
            if (isset($this->params[$property])) {
                return $this->params[$property];
            } else {
                helpReturn(602, $property);
            }
        }
    }

    public function __set($property, $value)
    {
        if (in_array($property, array_keys(getClassProperties(Request::class, 'private')))) {
            helpReturn(603, $property);
        } else {
            $this->params[$property] = $value;
        }
    }

    /**
     * return request url
     */
    public function getUrl()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * 獲得url路徑最後一個值
     */
    public function getUrlParam()
    {
        $urlParam = $this->urlParam;
        if (is_numeric($urlParam)) {
            return $urlParam;
        } else {
            helpReturn(408);
        }
    }

    /**
     * 獲得當前請求的方法
     */
    public function getRequestMethod()
    {
        return $this->methods;
    }

    /**
     * 獲取request的所有payload參數
     */
    public function all()
    {
        $requestData = $this->params;
        return $requestData;
    }
}
