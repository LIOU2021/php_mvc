<?

namespace App\Http;

use Exception;

class Http
{
    private $methods;
    private $uri;
    private $uriLn;

    public function __construct()
    {
        $this->methods = $_SERVER['REQUEST_METHOD'];
        $this->uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $this->uriLn = count($this->uri);
    }

    // public function getMethods()
    // {
    //     return $this->methods;
    // }

    /**
     * 可接受的API格式
     * 
     * @param string $method 請求方法
     * @param boolean $urlParam 是否接受url參數
     * @param callable $callback 
     */
    public function accept(string $method, bool $urlParam = false, callable $callback)
    {
        if ($method != $this->methods) {
            // echo 'method error !';
            return null;
        }

        if ($urlParam && !is_numeric($this->uri[$this->uriLn - 1])) {
            // echo 'urlParam error !';
            return null;
        }

        if (is_numeric($this->uri[$this->uriLn - 1])&&!$urlParam) {
            // echo 'urlParam error !';
            return null;
        }

        if (is_callable($callback)) {
            // echo "It is function";
            return $callback();
        } else {
            echo "It is not function";
            exit;
        }
    }
}
