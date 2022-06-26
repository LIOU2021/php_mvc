<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Test;

class TestController extends Controller
{
    private $test;
    private $url;

    public function __construct(
        // Request $request
        )
    {
        // $this->url=$request->getUrl();
        $this->test = 'TestController的建構子';
    }

    public function show(
        // Request $request
    ){
        // return $this->url;
        $request=new Request();
        return $request->getUrl();
        // return 'run';
    }

    public function index2(string $p2)
    {
        return 'TestController@test';
    }

    public function index(Request $request)
    {
        // dd($_REQUEST);
        // $request->age2=100;
        // $request->age=1012;
        // $request->params2 ='test';
        // return $request->age2;
        // return $request->all();

        // return $request->age;
        // return $request->name;
        // return $request->all();
        return $request->getUrl();
    }
}
