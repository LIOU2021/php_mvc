<?php

namespace App\Controllers;

class Controller{
    
    /**
     * API所能接受的方法。預設是全部。
     */
    protected $action=["*"];

    /**
     * Get request accept method
     * 
     * @return array
     */
    public function getAction(){
        return $this->action;
    }
}