## LOOTOM 流媒体服务第三方接入获取拉流url的laravel扩展
---


### 安装
    
* composer:
    
    ```
    composer require wanghouting/ltstream-php-ext
    ```


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
4. 添加回调路由:

    ```
    Route::get('ltstream/callback','\LTStream\Extension\Controllers\LTStreamCallbackController@callback');
    ```
    注意路由地址要和在平台上注册填写的回调url保持一至，上面对应的是http://ip:port/ltstream/callback

5. 开始使用:
    
    ```php
    $HttpFlvLiveUrl =   \LTStream\Extension\Facades\LTStream::getMainFlvLiveUrl($code);
    ```
    
    > 方法说明:
     
     *  string getMainFlvLiveUrl($code)     : 获取http-flv直播流主码流地址
     
     *  string getMainTsLiveUrl($code)      : 获取http-ts直播流主码流地址
     *  string getSubFlvLiveUrl($code)      : 获取http-flv直播流辅码流地址
     *  string getSubTsLiveUrl($code)       : 获取http-ts直播流辅码流地址
        

### 功能清单
    
    
    
  - 支持http-flv直播;
  
  - 支持http-ts直播;
  
  - 支持主流/辅流; 
  
  - 支持按需拉流;  
  
  

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
















