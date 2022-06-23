<?php

namespace App\Controllers;

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
        $all = $this->limitAPI('GET', false, function () {
            $user = new User();
            return $user->all();
        });

        $show = $this->limitAPI('GET', true, function () {
            $user = new User();
            return $user->find($this->getUrlParam());
        });
 
        return $this->allowAPI([$all,$show]);
    }

    public function update()
    {
        // echo 'user controller update';
        return 'user controller update';
    }

    public function create()
    {
        // echo 'user controller create';
        return 'user controller create';
    }

    public function show(){
        // echo 'user controller show';
        return 'user controller show';
    }

    public function show2(){
        // echo 'user controller show';
        return 'user controller show2';
    }
}
