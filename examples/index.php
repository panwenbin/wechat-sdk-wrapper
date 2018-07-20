<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

/* // 把下面内容存为index.php文件放在你的项目目录下
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
*/

use panwenbin\wechat\Config;
use panwenbin\wechat\exceptions\WechatException;

spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);
    if (strpos($className, 'panwenbin/wechat/') === 0) {
        $filePath = __DIR__ . '/../src/' . substr($className, 17) . '.php';
        if (file_exists($filePath)) {
            include $filePath;
        }
    }
});

$config = new Config($conf['appid'], $conf['secret']);

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['test']) && preg_match('/^[a-z0-9_]+$/', $_GET['test'])) {
            $testFile = __DIR__ . '/' . $_GET['test'] . '.php';
            if (file_exists($testFile)) {
                include $testFile;
            }
        } else {
            include __DIR__ . '/bind.php';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include __DIR__ . '/autoreply.php';
    }
} catch (WechatException $e) {
    echo 'Exception occurred: ', get_class($e);
}