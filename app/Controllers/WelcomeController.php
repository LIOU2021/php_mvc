<?php

namespace App\Controllers;

class WelcomeController extends Controller
{
    public function index()
    {
        // header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Methods: *");
        // header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");
        // header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PATCH, OPTIONS");
        // header("Access-Control-Allow-Headers: X-Requested-With");
        // echo '123';

        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Methods: *");
        // header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");

        return 'welcome to my custom mvc framework !';
    }
}
