<?php

use App\Debug\Log;

require_once '../vendor/autoload.php';

$res['data']=[1,2,3];
$res['msg']='success !';
$res['status']=200;

echo Log::debug(__FILE__,__LINE__,$res);