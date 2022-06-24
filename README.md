# 說明
> 自製MVC框架，參考laravel與thinkphp

# config
> config/

# router
> 所有的Router 存放在 $GLOBALS['router']

> 兩種模式 env('ROUTERSTYLE')
1. laravel
2. thinkphp。命名規則為/controller/method/{id}

> 寫在routes/資料夾
1. 如果是api.php的話，API路由前贅會加入"/api"

> 注意事項
1. 路由開頭一定要有"/"斜線，比如 /user，這是正確的。
2. 路由中若有urlParam，限定只能添加在最後 ex:/user/{id}
3. 如果路由有使用urlParam的格式的話，那麼{id}為必填格式

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

# database 資料夾
> 單純放sql紀錄。本專案不打算開發類似migration的功能

# CLI
```
php minicli help

php minicli make:controller UserController
``` 

# 待開發
> 撰寫model的ORM

* all(V)
* find(V)
* update
* create
* delete

> 撰寫middleware

> CLI