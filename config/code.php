<?php

return [
    // success
    200 => "success !",

    // Router
    400 => "router style env error, only allow 'laravel' or 'thinkphp' !",
    401 => "controller not find !",
    402 => "method not defind !",
    403 => "this router not support this request method !",
    404 => "router not defind !",
    405 => "only allow one method reponse, but find two or more!",
    406 => "doesn't any route match !",
    407 => "duplicate router, already exists !",
    408 => "not match urlParam API format !",
    409 => "DI fail : method of controller arg error ! ",
    410 => "DI fail : construct of Class have some argument !",
    411 => "DI fail : method of Class have some argument !",
    412 => "DI fail : construct of Class argument error !",

    // sql error
    500 => "find model by id, but not find !",

    //class error
    601 => "try to call private property !",
    602 => "try to call undefined property !",
    603 => "try to set private property !",
    604 => "try to set undefined property !",
];
