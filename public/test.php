<?php

// require_once '../vendor/autoload.php';

// use App\Http\Request;

// class Test
// {
//     protected $arr = [];

//     public function __construct(Request $request)
//     {
//         echo $request->getUrlParam();

//         $arr['hello'] = function () {
//             echo 'hello';
//         };

//         $arr['help'] = function () {
//             echo 'hello';
//         };
//     }

//     public function registry($cli, $callback)
//     {
//         $this->arr[$cli] = $callback;
//     }

//     public function getCommand($cli)
//     {
//         return isset($this->arr[$cli]) ? $this->arr[$cli] : null;
//     }

//     public function run($name)
//     {
//         $command = $this->getCommand($name);
//         // var_dump($command);
//         // $this->arr[$name];
//         // var_dump($this->arr);
//         call_user_func($command);
//     }
// }

// $test = new Test();

// $test->registry('help',function(){
//     echo 'test111';
// });

// $test->run('help');

// $arr['help']=function(){
//     echo 'test222';
// };

// var_dump($arr['help']);
// call_user_func($arr['help']);
// $arr['help']();

use App\Controllers\TestController;

require_once '../vendor/autoload.php';

// $controller = new TestController();
// echo $controller->index([1,2,3]);

$constructor = new ReflectionMethod(TestController::class, 'index');
$parameters = $constructor->getParameters();

foreach ($parameters as $parameter) {
    $dependenceClass = (string) $parameter->getType()->getName();
    echo checkNeedDI($dependenceClass);
    echo "<br>";
}

function checkNeedDI(string $type)
{
    if(strpos($type,"\\")){
        return "use DI : ".$type;
    }else{
        return "don't use DI : ".$type;
    }
    
}
