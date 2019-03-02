## LOOTOM 流媒体服务第三方接入获取拉流token的laravel扩展
---


### 安装


    
    composer require wanghouting/ltstream-php-ext
    


### 配置



1. 注册 ServiceProvider(laravel 5.5+版本不需要手动注册):
     ```
    LTStream\Extension\LaravelServiceProvider::class,
     ```     
 
2. 发布配置文件:
 
    ```
    php artisan vendor:publish --provider="LTStream\Extension\LaravelServiceProvider" 
    ```   

3. 修改.env,增加:
    ```
    LTSTREAM_SERVER=平台地址:例如http://127.0.0.1:8091
    
    LTSTREAM_ACCESS_KEY=您的app_access_key
    
    LTSTREAM_SECRET=您的app_secret
    ```
4. 创建回调控制器:

    ```
    <?php

    namespace App\Http\Controllers;
    
    use LTStream\Extension\Traits\UseLTStreamCallback;
    
    class TestController extends Controller
    {
        use UseLTStreamCallback;
    
    }
    ```
    控制器使用 **UseLTStreamCallback trait**。注意，别忘了引入命名空间**use LTStream\Extension\Traits\UseLTStreamCallback**;
    
5. 添加路由:
    ```
    Route::get('stream/callback','TestController@callback');
    ```
    注意路由地址要和在平台上注册填写的回调url保持一至，上面对应的是http://ip:port/stream/callback

6. 开始使用:

    ```
    $res =  LTStream::getToken();
    ```
    
    > 返回结果打印
    
    ```
    array:3 [▼
      "code" => 200
      "data" => array:2 [▼
        "expire" => 1551545254300
        "token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhcHBfYWNjZXNzX2tleSI6Ik9UWTM4ZGluc3hDSE1SVzEiLCJleHBpcmUiOjE1NTE1NDUyNTQzMDAsIm5hbWUiOiJ0ZXN0In0=.Nv26d314tS/A/GYFxBkPuL ▶"
      ]
      "message" => "200 OK"
    ]
    ```
    
    > 然后在请求拉流的时候带上token,例如：http://127.0.0.1:8091/live/1.flv?token=生成的token




### 状态码说明



   | 状态码  |  说明                        |
   | :-----: | :----:                       |
   | 200  | ok                              |
   | 400  | 非法的请求地址                  |
   | 404  | 请求的地址不存在                |
   | 500  | 服务器异常                      |
   | 1001 | 无效的签名（signature）         |
   | 1002 | 签名已过期                      |
   | 1003 | appAccessKey和appSecret不正确   |
   | 1004 | 第三方回调url请求超时           |
   | 1005 | 第三方回调url返回拒绝           |
   | 1006 | 第三方被禁用                    |
   | 1101 | 生成token失败                   |
   | 1102 | 无效的token                     |
   | 1103 | token已过期                     |
   | 1201 | 未找到码流地址                  |
   | 1202 | 拉流失败                        |
   | 2001 | 请求参数有误                    |
















