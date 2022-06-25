<?php

class route{
    private static array $middleware = [];
   
    public function echo(){
        echo '11';
    }

    public static function middleware(array $middleware)
    {
        $route = new route();
        return $route->setMiddleware($middleware);
    }

    
    public static function setMiddleware(array $middleware)
    {
        self::$middleware = $middleware;
        return new self;
    }

    public static function add()
    {
        // return $this->middleware;
        var_dump(self::$middleware);
       self::setMiddleware([]);
    }
}

var_dump( route::middleware(['auth']));
echo "<br>";
( route::middleware(['auth'])->add());
echo "<br>";
(route::add());
