# 說明
> 自製MVC框架，參考laravel與thinkphp

# 路由命名規則
> /controller/method/{id?}

# 環境變數
> cp .env.example .env

# 註冊全域變數
> app/Providers/AppProvider

# Controller
```
可透過下列方法來控制Controller中的方法只在特定API格式中執行。
比如下列是指接受/user這種讀取全部的格式
$this->limitAPI('GET', false, function () {
            return User::all();
        });

下列是指接受/user/{id}這種讀取特定ID的格式。此範例為讀取id為30的user資料。
$this->limitAPI('GET', true, function () {
            return User::find(30);
        });        
```

# Model
> db table 名稱 對應model名稱
> 比如User.php，對應的就是user這張表
> sql的create database與table需要自行透過sql新增

# database 資料夾
> 單純放sql紀錄。本專案不打算開發類似migration的功能

# 待開發
> 撰寫model的ORM
> all(V)
> show(V)
> update
> create
> delete