<?php

namespace App\Http\Middleware;

use App\Http\Request;

class CorsMiddleware extends Middleware
{
    /**
     * redirect url
     */
    protected $redirect = "/";

    protected function handle(Request $request = null)
    {
        $this->cors();

        $yourCondition = true;

        if ($yourCondition) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * allow cors
     */
    public function cors()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: Methods,AccountKey,x-requested-with, Content-Type, origin, authorization, accept, client-security-token, host, date, cookie, cookie2");
        header('Access-Control-Max-Age: 86400');
    }
}
