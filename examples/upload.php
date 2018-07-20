<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

use panwenbin\wechat\apis\Media;
use panwenbin\wechat\apis\Token;
use panwenbin\wechat\messages\upload\Article;
use panwenbin\wechat\messages\upload\News;

$tokenApi = new Token($config);
$mediaApi = new Media($tokenApi);
$res = $mediaApi->uploadThumb('1.jpg');
var_dump($res);exit;

$tokenApi = new Token($config);
$mediaApi = new Media($tokenApi);
$article = new Article();
$article->thumb_media_id = $res['media_id'];
$article->content = 'content';
$article->title = 'title';
$article->author = 'author';
$article->digest = 'digest';
$article->content_source_url = 'http://www.abcd.com/';
$article->show_cover_pic = 0;
$news = new News();
$news->addArticle($article);
$res = $mediaApi->uploadNews($news);