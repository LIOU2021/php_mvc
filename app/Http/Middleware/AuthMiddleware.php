<?php

namespace App\Http\Middleware;

use App\Http\Request;

class AuthMiddleware extends Middleware
{
    /**
     * redirect url
     */
    protected $redirect = "/";

    protected function handle(Request $request=null)
    {
        $yourCondition=true;
        
        if ($yourCondition) {
            return true;
        } else {
            return false;
        }
    }
}
