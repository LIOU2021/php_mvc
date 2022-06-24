<?php

namespace App\Controllers;

use App\Http\Request;

class TestController extends Controller
{
    private $test;

    public function __construct()
    {
        $this->test = 'TestController的建構子';
    }

    public function index2(string $p2)
    {
        return 'TestController@test';
    }

    public function index(Request $request)
    {
        return $request->getUrlParam()."$this->test";
    }

    public function index3()
    {
        // $request = new Request ();
        // return $request->getUrlParam()."$this->test";
    }

    public function index1(Request $request, string $p2)
    {
        return 'TestController@test2';
    }
}
