<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\reply;


class NewsReplyMessage extends BaseReplyMessage
{
    public $msgType = 'news';
    public $articleCount;
    public $articles;

    public function addArticle(Article $article)
    {
        if (count($this->articles) >= 8) {
            return false;
        }
        if (is_null($article) || empty($article->title) || empty($article->description) || empty($article->picUrl) || empty($article->url)) {
            return false;
        }
        $this->articles[] = $article;
        $this->articleCount = count($this->articles);
        return true;
    }
}

class Article
{
    public $title;
    public $description;
    public $picUrl;
    public $url;

    public function __construct(string $title, string $description, string $picUrl, string $url)
    {
        $this->title = $title;
        $this->description = $description;
        $this->picUrl = $picUrl;
        $this->url = $url;
    }

    public function __toString()
    {
        $xml = '';
        foreach ($this as $key => $value) {
            $xml .= BaseReplyMessage::buildOneLevelXML($key, $value);
        }
        return $xml;
    }
}