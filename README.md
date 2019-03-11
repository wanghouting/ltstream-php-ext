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
     
        - 请求
        
           | 参数  |  说明                        |
           | :-----: | :----:                   |
           | $code  | 设备code                   |
           
        - 返回值 
           
            ```
            http://192.168.88.103:8091/live/D24FF8DAF7334244AF4C8D57962AD798.flv?type=1&token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhcHBfYWNjZXNzX2tleSI6IjNiOTlhYzg1YWM1MTRkZWQiLCJleHBpcmUiOjE1NTIyODU3MDU3OTcsIm5hbWUiOiLolbLmmKUifQ==.FxicWmq3z+JpkNrPa93c5YpEtVOm25h+LhF3HfM6jIY=
            ```
         
     *  string getMainTsLiveUrl($code)      : 获取http-ts直播流主码流地址
     
         - 请求
         
            | 参数  |  说明                        |
            | :-----: | :----:                   |
            | $code  | 设备code                   |
            
         - 返回值 
            
             ```
             http://192.168.88.103:8091/live/D24FF8DAF7334244AF4C8D57962AD798.ts?type=1&token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhcHBfYWNjZXNzX2tleSI6IjNiOTlhYzg1YWM1MTRkZWQiLCJleHBpcmUiOjE1NTIyODU3MDU3OTcsIm5hbWUiOiLolbLmmKUifQ==.FxicWmq3z+JpkNrPa93c5YpEtVOm25h+LhF3HfM6jIY=
             ```
     *  string getSubFlvLiveUrl($code)      : 获取http-flv直播流辅码流地址
          - 请求
          
             | 参数  |  说明                        |
             | :-----: | :----:                   |
             | $code  | 设备code                   |
             
          - 返回值 
             
              ```
              http://192.168.88.103:8091/live/D24FF8DAF7334244AF4C8D57962AD798.flv?type=2&token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhcHBfYWNjZXNzX2tleSI6IjNiOTlhYzg1YWM1MTRkZWQiLCJleHBpcmUiOjE1NTIyODU3MDU3OTcsIm5hbWUiOiLolbLmmKUifQ==.FxicWmq3z+JpkNrPa93c5YpEtVOm25h+LhF3HfM6jIY=
              ```
     
     *  string getSubTsLiveUrl($code)       : 获取http-ts直播流辅码流地址
        - 请求
          
             | 参数  |  说明                        |
             | :-----: | :----:                   |
             | $code  | 设备code                   |
             
        - 返回值 
             
          ```
          http://192.168.88.103:8091/live/D24FF8DAF7334244AF4C8D57962AD798.ts?type=2&token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhcHBfYWNjZXNzX2tleSI6IjNiOTlhYzg1YWM1MTRkZWQiLCJleHBpcmUiOjE1NTIyODU3MDU3OTcsIm5hbWUiOiLolbLmmKUifQ==.FxicWmq3z+JpkNrPa93c5YpEtVOm25h+LhF3HfM6jIY=
          ```
          
     * mixed  addMonitor($name,$path,$subPath,$address)  : 添加监控设备(需要拥有添加权限)
        - 请求
          
             | 参数  |  说明                        |
             | :-----: | :----:                   |
             | $name  | 设备名称                   |
             | $path  | 设备主码流地址                   |
             | $subPath  | 设备辅码流地址                   |  
             | $address  | 设备地址                   | 
             
        - 返回值  
            ```
          Array
          (
              [code] => 200
              [data] => Array
                  (
                      [address] => 123123
                      [code] => 08925c476fd14491881f354200101143
                      [online] => 1
                      [path] => rtsp://admin:12345678q@192.168.88.111:554/Streaming/Channels/001
                      [snapshot] => 
                      [sub_path] => rtsp://admin:12345678q@192.168.88.111:554/Streaming/Channels/002
                  )
          
              [message] => 操作成功
          )
            ```
            
             | 返回值  |  说明                        |
             | :-----: | :----:                   |
             | address  | 设备地址                   |
             | code  |   设备code                |
             | online  | 设备在线状态,0离线,1在线                    |  
             | path  | 设备主码流地址                   | 
             | sub_path  | 设备辅码流地址                   | 
             | snapshot  | 设备快照                   | 
             
     * mixed  updateMonitor($code,$name,$path,$subPath,$address)  : 更新监控设备(需要拥有更新权限)
        - 请求
          
             | 参数  |  说明                        |
             | :-----: | :----:                   |
             | $code  | 设备code                   |
             | $name  | 设备名称                   |
             | $path  | 设备主码流地址                   |
             | $subPath  | 设备辅码流地址                   |  
             | $address  | 设备地址                   | 
             
        - 返回值  
            ```
          Array
          (
              [code] => 200
              [data] => Array
                  (
                      [address] => 123123
                      [code] => 08925c476fd14491881f354200101143
                      [online] => 1
                      [path] => rtsp://admin:12345678q@192.168.88.111:554/Streaming/Channels/001
                      [snapshot] => 
                      [sub_path] => rtsp://admin:12345678q@192.168.88.111:554/Streaming/Channels/002
                  )
          
              [message] => 操作成功
          )
            ```
            
             | 返回值  |  说明                        |
             | :-----: | :----:                   |
             | address  | 设备地址                   |
             | code  | 设备code                   |
             | online  | 设备在线状态,0离线,1在线                   |  
             | path  | 设备主码流地址                   | 
             | sub_path  | 设备辅码流地址                   | 
             | snapshot  | 设备快照                   |      
             
     * mixed  getMonitorList()  : 获取所有监控设备
        - 请求
          
             | 参数  |  说明                        |
             | :-----: | :----:                   |
             
        - 返回值  
            ```
            Array
            (
                [code] => 200
                [data] => Array
                    (
                        [0] => Array
                            (
                                [address] => 办公室我的位置
                                [code] => D24FF8DAF7334244AF4C8D57962AD798
                                [online] => 1
                                [path] => rtsp://admin:12345678q@192.168.88.164:554/Stream/Channels/001
                                [snapshot] => 1
                                [sub_path] => /rtsp://admin:12345678q@192.168.88.164:554/Stream/Channels/002
                            )
            
                        [1] => Array
                            (
                                [address] => 123123
                                [code] => 70512aa7b93d444da89549386c8ae941
                                [online] => 1
                                [path] => rtsp://admin:12345678q@192.168.88.111:554/Streaming/Channels/001
                                [snapshot] => 
                                [sub_path] => rtsp://admin:12345678q@192.168.88.111:554/Streaming/Channels/002
                            )
            
                        [2] => Array
                            (
                                [address] => 123123
                                [code] => 08925c476fd14491881f354200101143
                                [online] => 1
                                [path] => rtsp://admin:12345678q@192.168.88.111:554/Streaming/Channels/001
                                [snapshot] => 
                                [sub_path] => rtsp://admin:12345678q@192.168.88.111:554/Streaming/Channels/002
                            )
            
                    )
            
                [message] => 操作成功
            )
            ```
            
             | 返回值  |  说明                        |
             | :-----: | :----:                   |
             | address  | 设备地址                   |
             | code  | 设备code                   |
             | online  | 设备在线状态,0离线,1在线                   |  
             | path  | 设备主码流地址                   | 
             | sub_path  | 设备辅码流地址                   | 
             | snapshot  | 设备快照                   |  
            
      * mixed  getMonitorPaginate($page = 1,$pageSize = 15)  : 分页获取监控设备
         - 请求
           
              | 参数  |  说明                        |
              | :-----: | :----:                   |
              | $page  | 第几页 (默认1)                  |
              | $pageSize  | 每页显示条数(默认15)                  |
              
         - 返回值  
             ```
            Array
            (
                [code] => 200
                [data] => Array
                    (
                        [list] => Array
                            (
                                [0] => Array
                                    (
                                        [address] => 办公室我的位置
                                        [code] => D24FF8DAF7334244AF4C8D57962AD798
                                        [online] => 1
                                        [path] => rtsp://admin:12345678q@192.168.88.164:554/Stream/Channels/001
                                        [snapshot] => 1
                                        [sub_path] => /rtsp://admin:12345678q@192.168.88.164:554/Stream/Channels/002
                                    )
            
                                [1] => Array
                                    (
                                        [address] => 123123
                                        [code] => 70512aa7b93d444da89549386c8ae941
                                        [online] => 1
                                        [path] => rtsp://admin:12345678q@192.168.88.111:554/Streaming/Channels/001
                                        [snapshot] => 
                                        [sub_path] => rtsp://admin:12345678q@192.168.88.111:554/Streaming/Channels/002
                                    )
            
                                [2] => Array
                                    (
                                        [address] => 123123
                                        [code] => 08925c476fd14491881f354200101143
                                        [online] => 1
                                        [path] => rtsp://admin:12345678q@192.168.88.111:554/Streaming/Channels/001
                                        [snapshot] => 
                                        [sub_path] => rtsp://admin:12345678q@192.168.88.111:554/Streaming/Channels/002
                                    )
            
                            )
            
                        [total] => 3
                    )
            
                [message] => 操作成功
            )
             ```
             
              | 返回值  |  说明                        |
              | :-----: | :----:                   |
              | total  | 设备总数                   |
              | address  | 设备地址                   |
              | code  |   设备code                |
              | online  | 设备在线状态,0离线,1在线                    |  
              | path  | 设备主码流地址                   | 
              | sub_path  | 设备辅码流地址                   | 
              | snapshot  | 设备快照                   | 
              
     * deleteMonitor ($code) 删除设备(需要拥有删除权限)
          - 请求
                    
               | 参数  |  说明                        |
               | :-----: | :----:                   |
               | $code  | 设备code                  |
               
          - 返回值  
              ```   
              Array
              (
                  [code] => 200
                  [data] => null
                  [message] => 操作成功
              ) 
              ```  
     * getMonitorInfo ($code) 获取设备详细信息
          - 请求
                    
               | 参数  |  说明                        |
               | :-----: | :----:                   |
               | $code  | 设备code                  |
               
          - 返回值  
              ```   
            Array
            (
                [code] => 200
                [data] => Array
                    (
                        [address] => 办公室我的位置
                        [code] => D24FF8DAF7334244AF4C8D57962AD798
                        [online] => 1
                        [path] => rtsp://admin:12345678q@192.168.88.164:554/Stream/Channels/001
                        [snapshot] => 1
                        [sub_path] => /rtsp://admin:12345678q@192.168.88.164:554/Stream/Channels/002
                    )
            
                [message] => 操作成功
            )
              ```       
            | 返回值  |  说明                        |
            | :-----: | :----:                   |
            | address  | 设备地址                   |
            | code  |   设备code                |
            | online  | 设备在线状态,0离线,1在线                    |  
            | path  | 设备主码流地址                   | 
            | sub_path  | 设备辅码流地址                   | 
            | snapshot  | 设备快照                   |                         
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
   | 2002 | 权限不足                   | 















