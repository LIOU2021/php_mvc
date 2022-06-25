<?php

namespace App\Http;

class Test{
    private $name;
    
    public function __construct()
    {
        $this->name='hello';
    }

    public function print(){
        return $this->name;
    }
}