<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

use panwenbin\wechat\exceptions\SignatureInvalidException;
use panwenbin\wechat\messages\BindRequest;

$bindRequest = new BindRequest($conf['token'], $_GET);
try {
    echo $bindRequest->reply();
} catch (SignatureInvalidException $e) {
    header("HTTP/1.0 400 Bad request");
    echo 'SignatureInvalidException ', 'code:', $e->getCode(), ', msg:', $e->getMessage();
}