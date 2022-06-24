<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Test;

class TestController extends Controller
{
    private $test;

    public function __construct(Request $request)
    {
        $this->test = 'TestController的建構子';
    }

    public function index2(string $p2)
    {
        return 'TestController@test';
    }

    public function index(Test $wel,Request $request)
    {
        echo $wel->index();
        return $request->getUrlParam()."$this->test";
    }

    public function index3()
    {
        $request = new Request ();
        return $request->getUrlParam()."$this->test";
    }

    public function index1(Request $request, string $p2)
    {
        return 'TestController@test2';
    }
}
