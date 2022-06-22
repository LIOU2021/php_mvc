<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends Controller{
    
    protected $action=["POST","GET","PUT","DELETE"];

    public function index(){
        // echo 'user controller index';
        // echo $this->action;
        return User::all();
        return "user controller index";
    }

    public function edit(){
        // echo 'user controller edit';
        return 'user controller edit';
    }
}