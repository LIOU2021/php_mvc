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
        if ($status != 200) {
            header("HTTP/1.1 404 Not Found");
        }

        header('Content-Type: application/json; charset=utf-8');
        $code = require_once('../config/code.php');
        $res['status'] = $status;

        if (isset($code[$status])) {
            $res['msg'] = $code[$status];
            $res['data'] = $data;
            echo json_encode($res);
            exit;
        } else {
            header("HTTP/1.1 404 Not Found");

            $res['status'] = null;
            $res['msg'] = 'error code not defind : ' . $status;
            $res['data'] = null;
            echo json_encode($res);
            exit;
        }
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

if (!function_exists('get_caller_info')) {

    /**
     * 獲取呼叫函數的檔案名稱
     *
     * @return string
     */
    function get_caller_info()
    {
        $c = '';
        $file = '';
        $func = '';
        $class = '';
        $trace = debug_backtrace();
        if (isset($trace[2])) {
            $file = $trace[1]['file'];
            $func = $trace[2]['function'];
            if ((substr($func, 0, 7) == 'include') || (substr($func, 0, 7) == 'require')) {
                $func = '';
            }
        } else if (isset($trace[1])) {
            $file = $trace[1]['file'];
            $func = '';
        }
        if (isset($trace[3]['class'])) {
            $class = $trace[3]['class'];
            $func = $trace[3]['function'];
            $file = $trace[2]['file'];
        } else if (isset($trace[2]['class'])) {
            $class = $trace[2]['class'];
            $func = $trace[2]['function'];
            $file = $trace[1]['file'];
        }
        if ($file != '') $file = basename($file);
        $c = $file . ": ";
        $c .= ($class != '') ? ":" . $class . "->" : "";
        $c .= ($func != '') ? $func . "(): " : "";
        return ($c);
    }
}

if (!function_exists('dd')) {
    /**
     * 除錯print
     */
    function dd(...$data)
    {
        echo '<pre>';

        foreach ($data as $item) {
            echo var_dump($item) . "\n\n";
        }

        echo '</pre>';
        exit;
    }
}
if (!function_exists('getClassProperties')) {
    /**
     * use ReflectionClass get properties
     */
    function getClassProperties($className, $types = 'public')
    {
        $ref = new ReflectionClass($className);
        $props = $ref->getProperties();
        $props_arr = array();
        foreach ($props as $prop) {
            $f = $prop->getName();

            if ($prop->isPublic() and (stripos($types, 'public') === FALSE)) continue;
            if ($prop->isPrivate() and (stripos($types, 'private') === FALSE)) continue;
            if ($prop->isProtected() and (stripos($types, 'protected') === FALSE)) continue;
            if ($prop->isStatic() and (stripos($types, 'static') === FALSE)) continue;

            $props_arr[$f] = $prop;
        }
        if ($parentClass = $ref->getParentClass()) {
            $parent_props_arr = getClassProperties($parentClass->getName()); //RECURSION
            if (count($parent_props_arr) > 0)
                $props_arr = array_merge($parent_props_arr, $props_arr);
        }
        return $props_arr;
    }
}

if (!function_exists('prepare')) {
    /**
     * 用於sql query 前的 prepare statement
     */
    function prepare($string)
    {
        if (gettype($string) == 'string') {
            return "'" . htmlspecialchars($string, ENT_QUOTES) . "'";
        } else {
            return null;
        }
    }
}
