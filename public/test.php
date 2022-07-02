<?php

use App\Debug\Log;

require_once '../vendor/autoload.php';

// $res['data']=[1,2,3];
// $res['msg']='success !';
// $res['status']=200;

// echo Log::debug(__FILE__,__LINE__,$res);

// echo ;
// var_dump(config('code.404'));
echo json_encode(config('code.4041'),JSON_PRETTY_PRINT);