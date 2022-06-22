<?php

namespace App\Controllers;

use App\Http\Http;
use App\Models\User;

class UserController extends Controller
{

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
