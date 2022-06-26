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

        if (count($_REQUEST)) {
            foreach ($_REQUEST as $index => $item) {
                $this->params[$index] = $item;
            }
        }

        $str_data = json_decode(file_get_contents('php://input'), true);
        if (gettype($str_data) == 'array' && count($str_data)) {
            foreach ($str_data as $index => $item) {
                $this->params[$index] = $item;
            }
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
                return null;
                // helpReturn(602, $property);
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

    /** 
     * Get hearder Authorization
     * */
    public function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
    /**
     * get access token from header
     * */
    public function bearerToken()
    {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}
