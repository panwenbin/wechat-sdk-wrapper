<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

use panwenbin\wechat\apis\MassMessage;
use panwenbin\wechat\apis\Token;
use panwenbin\wechat\messages\mass\TextMassMessage;

$msg = new TextMassMessage();
$msg->content = '群发消息';

$tokenApi = new Token($config);
$massMessageApi = new MassMessage($tokenApi);
$res = $massMessageApi->send($msg);
