<?php

namespace App\Controllers;

use App\Http\Http;
use App\Models\User;

class UserController extends Controller
{

    /**
     * 宣告該Controller可支援的請求方法
     * 
     * 如果無特別覆寫，那麼將會支持全部的request methods
     */
    protected $action = ["POST", "GET", "PUT", "DELETE"];

    public function index()
    {
        $this->limitAPI('GET', false, function () {
            return User::all();
        });
    }

    public function edit()
    {
        // echo 'user controller edit';
        return 'user controller edit';
    }
}
