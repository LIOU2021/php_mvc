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

# 待開發
> 撰寫model的ORM