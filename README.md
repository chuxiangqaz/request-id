
# x-request-id for lumen

> **对 lumen/laravel 项目 x-request-id 的包**

- [x] 日志增加 request id
- [x] HTTP/CLI/QUEUE 增加 request id
- [x] 请求别的第三方服务增加 request id
- [] 响应增加 request id


## 快速使用

1. 安装
```phpregexp
composer require chuxiangqaz/x-request-id
```

2. 使用
```php
// vim bootstrap/app.php
$app->register(\XRequestID\AppServiceProvider::class);
$app->register(\XRequestID\Logging\LoggingProvider::class);
```


## 文档说明

### 1. 如何在请求别的第三方服务增加 request id
```php
use GuzzleHttp\Client;

$cof = [
    'options'      => [
        'timeout'  => 60.0,
        'headers'  => [
            'Content-type' => 'application/json',
        ],
        'handler' => \App\MiddleWare::getHandlerStack(),
        'debug' => true
    ],
];

$client = new Client($cof);
$response = $client->get('http://httpbin.org/get');

```

### 2. queue 的日志的 requestID是什么样子呢
因为队列的request id 是针对单个消息的，因此不一样的消息 request id 不一样。形式全部如下: ` ${request_id}_${msg_id}`

```phpregexp
// 假设服务启动的时候
$requestId = '0bdff8095c8bf1b38775bf35547a1317';
// 从队列中拿取的消息id = 5cf41e52d71e8f9417c3c6de0741cf67
// 则我们全局的 request id, 以及日志中的:
$requestId  = '0bdff8095c8bf1b38775bf35547a1317_5cf41e52d71e8f9417c3c6de0741cf67'

```

