<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\upload;


class News
{
    protected $articles;

    public function addArticle(Article $article)
    {
        if (is_null($article) || count($this->articles) >= 8) {
            return false;
        }
        $this->articles[] = $article;
        return true;
    }

    public function toJson()
    {
        return json_encode(['articles' => $this->articles], JSON_UNESCAPED_UNICODE);
    }
}