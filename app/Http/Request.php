<?php

namespace App\Http;

class Request{
    
    private $payload;

    public function __construct()
    {
        $this->payload="router 的建構子";
    }

    public function getUrlParam(){
        return '173893'.$this->payload;
    }
}