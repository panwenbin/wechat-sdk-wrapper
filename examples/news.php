<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

use panwenbin\wechat\apis\MassMessage;
use panwenbin\wechat\apis\Media;
use panwenbin\wechat\apis\Token;
use panwenbin\wechat\forms\ArticleForm;
use panwenbin\wechat\forms\NewsForm;
use panwenbin\wechat\messages\mass\MpNewsMassMessage;

$articleForm = new ArticleForm();
$articleForm->thumb_url = 'http://wx.panwenbin.com/1.jpg';
$articleForm->content = '<img src="http://wx.panwenbin.com/1.jpg">hello';
$articleForm->content_source_url = 'http://www.panwenbin.com/';
$articleForm->show_cover_pic = 1;
$articleForm->title = '标题';
$articleForm->author = 'panwenbin';

$news = new NewsForm();
$news->addArticle($articleForm);

$tokenApi = new Token($config);
$mediaApi = new Media($tokenApi);

$news = $news->toUploadNews($mediaApi);
$response = $mediaApi->uploadNews($news);
if (isset($response['type'], $response['media_id']) && $response['type'] == 'news') {
    $mediaId = $response['media_id'];
    $mpNews = new MpNewsMassMessage();
    $mpNews->media_id = $mediaId;
    $mpNews->to = 100;
    $massMessageApi = new MassMessage($tokenApi);
    $res = $massMessageApi->send($mpNews);
    var_dump($res);
}
