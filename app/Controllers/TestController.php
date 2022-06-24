<?php

namespace App\Controllers;

use App\Http\Request;

class TestController extends Controller
{
    public function index2(string $p2)
    {
        return 'TestController@test';
    }

    public function index(Request $request)
    {
        return $request->getUrlParam();
    }

    public function index1(Request $request,string $p2)
    {
        return 'TestController@test2';
    }
}
