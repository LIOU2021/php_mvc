<?php

namespace App\Http;

class Kernel
{

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\AuthMiddleware::class,
        'test' => \App\Http\Middleware\TestMiddleware::class,
    ];

    public function getRouteMiddleware(){
        return $this->routeMiddleware;
    }
}
