## 安装
```
composer require panwenbin/wechat-sdk-wrapper
```

## example
把下面内容存为index.php文件放在你的项目目录下，填上appid、secret、token值
```
<?php
include __DIR__ . '/vendor/autoload.php';

$conf = [
    'appid' => '',
    'secret' => '',
    'token' => '',
    'logFile' => 'log.txt', // 默认值
];

include __DIR__ . '/vendor/panwenbin/wechat-sdk-wrapper/examples/log.php';
include __DIR__ . '/vendor/panwenbin/wechat-sdk-wrapper/examples/index.php';
```
然后在公众平台后台绑定此地址为回调接口  
试着对它说'hi'