<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

use panwenbin\wechat\apis\Tag;
use panwenbin\wechat\apis\Token;
use panwenbin\wechat\apis\User;

$tokenApi = new Token($config);
$userApi = new User($tokenApi);
$response = $userApi->getList();
if (isset($response['total'], $response['data'], $response['data'])) {
    $openidList = array_column($response['data'], 'openid');
    $tagApi = new Tag($tokenApi);
    $response = $tagApi->create('all');
    if (isset($response['tag'], $response['tag']['id'])) {
        $tagId = $response['tag']['id'];
        $response = $tagApi->batchTagging($openidList, $tagId);
        var_dump($response);
    }
}