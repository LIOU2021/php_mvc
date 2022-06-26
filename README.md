# 說明
> 自製MVC框架，參考laravel與thinkphp

> use php7.4

> use mysql

# config
> config/

# router
> 所有的Router 存放在 $GLOBALS['router']

> 兩種模式 env('ROUTERSTYLE')
1. laravel
2. thinkphp。命名規則為/controller/method/{id}。
3. thinkphp 模式下 /controller/method/{id} 與 /controller/method 導向的controller@method是一樣的

> 寫在routes/資料夾
1. 如果是api.php的話，API路由前贅會加入"/api"，並且允許CORS

> 注意事項
1. 路由開頭一定要有"/"斜線，比如 /user，這是正確的。
2. thinkphp模式下，路由中若有urlParam，限定只能添加在最後 ex:/user/{id}
3. laravel模式下，如果路由有使用urlParam的格式的話，那麼{id}為必填格式

# request
```
自動DI後:

//api/user?id=2
$request->id;//2

//api/user?age=10&name=mark
$request->age;//10
$request->name;//mark

$request->getUrlParam();//獲得url路徑最後一個值
$request->getRequestMethod();//獲得當前請求的方法
$request->all();//獲取request的所有payload參數

```
> 其他方法請直接參考 app\Http\Request.php

# 環境變數
> cp .env.example .env

# 註冊全域變數
> app/Providers/AppProvider

# 全域function
> app/helpers.php

# Controller
```
可透過下列方法來控制Controller中的方法只在特定API格式中執行。
比如下列是指接受/user這種讀取全部的格式
$all = $this->limitAPI('GET', false, function () {
            return User::all();
        });

下列是指接受/user/{id}這種讀取特定ID的格式。此範例為讀取id為30的user資料。
$show = $this->limitAPI('GET', true, function () {
            return User::find(30);
        });     

最後透過底下方法去做邏輯判斷，並且回傳。
return $this->allowAPI([$all,$show]);        
```

# Model
> db table 名稱 對應model名稱

> 比如User.php，對應的就是user這張表

> sql的create database與table需要自行透過sql新增

```
方法

User:find($id);

User:all();

// find user by id 
$user = new User();
$name = $request->name;
$name = prepare($name);
$user->query("select * from user where name = $name;");
// return $model->getQuery(); //get query string
return $user->exec();

// update user by id
$id = $request->getUrlParam();
$originUserData = $user->find($id);
$name = $request->name??$originUserData['name'];
$email = $request->email??$originUserData['email'];
$phone = $request->phone??$originUserData['phone'];
$name = prepare($name);
$email = prepare($email);
$phone = prepare($phone);
$user->query("update user set name = $name , email = $email , phone = $phone where id = $id;");
return $user->exec();

```
# database 資料夾
> 單純放sql紀錄。本專案不打算開發類似migration的功能

# CLI
```
php minicli help

php minicli make:controller UserController
php minicli make:model User
php minicli make:middleware TestMiddleware
``` 
> 如果在minicli註冊新的command的話，必須在help之前註冊，否則使用help指令時將會無法查詢到後續新增的指令

# DI 
> DI 模式只支援laravel router模式

> 參數從左至右，如果有使用DI，DI優先在左

> DI 目前只支援Router呼叫的那個class(大部分都是controller)做。該class中所被DI的Class中的建構子並不會被DI

> 關閉DI模式的話，Router中使用DI的Class中的建構子不可以有參數，否則會拋出410錯誤

> 關閉DI模式的話，Router中使用DI的Class中的方法不可以有參數，否則會拋出411錯誤

> DI 只支援到一層。比如UserController 可以DI UserRepository，但UserRepository中的建構子若還有參數，將會拋錯

> thinkphp router style 不支援DI，所以Controller的建構子與方法不可以有參數

# Middleware
> 如果DI模式開啟的話，在middleware中的handle(Request $request)會自動實現DI，否則$request就是null
> 建立Middleware後，要在app\Http\Kernel.php的$routeMiddleware中增加對應的值才能使用
> 建立在app\Http\Kernel.php的$middlewareGroups，是針對api.php與web.php做的中間層處理
```
使用方法

Route::middleware(['auth','test'])->get('/test/{id}', [TestController::class, 'show']);
Route::middleware(['auth','test'])->get('/test', [TestController::class, 'show']);
Route::middleware(['test'])->get('/test', [TestController::class, 'index']);
Route::middleware(['test','auth'])->group(function(){
    Route::get('/test2', [TestController::class, 'index']);
    Route::get('/test3', [TestController::class, 'index']);
});

結合Router::prefix()方法
Route::prefix('world')->middleware(['test','auth'])->get('/test',[TestController::class,"index"]);
Route::middleware(['test','auth'])->prefix('world')->get('/test',[TestController::class,"index"]);
Route::prefix('world')->middleware(['test'])->group(function(){
    Route::get('/test',[TestController::class,"index"]);
    Route::post('/test',[WelcomeController::class,"index"]);
    Route::delete('/test',[WelcomeController::class,"index"]);
    Route::put('/test',[WelcomeController::class,"index"]);
});
Route::prefix('world')->group(function(){
    Route::get('/test',[TestController::class,"index"]);
    Route::get('/test/{id}',[TestController::class,"index"]);
    Route::post('/test',[WelcomeController::class,"index"]);
    Route::delete('/test',[WelcomeController::class,"index"]);
    Route::put('/test',[WelcomeController::class,"index"]);
});
```
# Log
```
$res['data']=[1,2,3];
$res['msg']='success !';
$res['status']=200;

Log::debug(__FILE__,__LINE__,$res);
//storage\logs\debug.log
```

# 待開發
> 最後測試在ubuntu能否正常運作
