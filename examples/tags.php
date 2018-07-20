<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

use panwenbin\wechat\apis\Tag;
use panwenbin\wechat\apis\Token;

$tokenApi = new Token($config);
$tagApi = new Tag($tokenApi);
$response = $response = $tagApi->get();
var_dump($response);