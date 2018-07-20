<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\forms;

use panwenbin\wechat\apis\Media;
use panwenbin\wechat\messages\upload\News as UploadNews;


/**
 * 封装对外表单格式，接收图文消息
 * @package panwenbin\wechat\forms
 */
class NewsForm
{
    /* @var \panwenbin\wechat\forms\ArticleForm[] $articles */
    protected $articles = [];

    public function addArticle(ArticleForm $article)
    {
        if (is_null($article) || count($this->articles) >= 8) {
            return false;
        }
        $this->articles[] = $article;
        return true;
    }

    /**
     * @param Media $media
     * @return UploadNews
     * @throws \panwenbin\wechat\exceptions\UploadFailedException
     * @throws \panwenbin\wechat\exceptions\WechatException
     */
    public function toUploadNews(Media $media)
    {
        $uploadNews = new UploadNews();
        foreach ($this->articles as $article) {
            $uploadNews->addArticle($article->toUploadArticle($media));
        }
        return $uploadNews;
    }
}