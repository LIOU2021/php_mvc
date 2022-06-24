<?php

namespace App\Controllers;

use App\Http\Request;
use App\Models\User;
use App\Repository\UserRepository;

class UserController extends Controller
{

    private $repo;
    
    /**
     * 宣告該Controller可支援的請求方法
     * 
     * 如果無特別覆寫，那麼將會支持全部的request methods
     */
    protected $action = ["POST", "GET", "PUT", "DELETE"];

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        switch (ROUTERSTYLE) {
            case 'laravel':
                return $this->repo->all();
                break;
            case 'thinkphp':
                $all = $this->limitAPI('GET', false, function () {
                    $user = new User();
                    return $user->all();
                });
        
                $show = $this->limitAPI('GET', true, function () {
                    $user = new User();
                    return $user->find($this->getUrlParam());
                });
        
                return $this->allowAPI([$all, $show]);
                break;
            default:
            return 'test...';
                break;
        }
    }

    public function update()
    {
        // echo 'user controller update';
        // return 'user controller update';
        return 'user controller update : ' . $this->getUrlParam();
    }

    public function create()
    {
        // echo 'user controller create';
        return 'user controller create';
    }

    public function show(Request $request)
    {
        return $this->repo->find($request->getUrlParam());
    }

    public function delete()
    {
        // echo 'user controller delete : '.$this->getUrlParam();
        return 'user controller delete : ' . $this->getUrlParam();
    }
}
