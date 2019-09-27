<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\apis;


use panwenbin\helper\Curl;
use panwenbin\wechat\messages\upload\News;

/**
 * 永久素材
 * @package panwenbin\wechat\apis
 */
class Material extends TokenBasedApi
{
    const API_ADD_NEWS = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token={ACCESS_TOKEN}';
    const API_UPDATE_NEWS = 'https://api.weixin.qq.com/cgi-bin/material/update_news?access_token={ACCESS_TOKEN}';
    const API_GET_MATERIAL = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token={ACCESS_TOKEN}';
    const API_DELETE_MATERIAL = 'https://api.weixin.qq.com/cgi-bin/material/del_material?access_token={ACCESS_TOKEN}';
    const API_COUNT_MATERIAL = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token={ACCESS_TOKEN}';

    /**
     * @param News $news
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "media_id": "MEDIA_ID"
     * }
     */
    public function addNews(News $news)
    {
        $apiUrl = $this->token->apiUrl(self::API_ADD_NEWS);
        $response = Curl::to($apiUrl)->withData($news->toJson())->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param string $mediaId
     * @param int $index
     * @param array $articles
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok"
     * }
     */
    public function updateNews(string $mediaId, int $index = 0, array $articles)
    {
        $apiUrl = $this->token->apiUrl(self::API_UPDATE_NEWS);
        $response = Curl::to($apiUrl)->withData(json_encode(['media_id' => $mediaId, 'index' => $index, 'articles' => $articles], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param string $mediaId
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回，图文
     * {
     *   "news_item": [
     *     {
     *       "title": "TITLE",
     *       "thumb_media_id": "THUMB_MEDIA_ID",
     *       "show_cover_pic": "SHOW_COVER_PIC(0/1)",
     *       "author": "AUTHOR",
     *       "digest": "DIGEST",
     *       "content": "CONTENT",
     *       "url": "URL",
     *       "content_source_url": "CONTENT_SOURCE_URL"
     *     }
     *   ]
     * }
     * 视频
     * {
     *   "title": "TITLE",
     *   "description": "DESCRIPTION",
     *   "down_url": "DOWN_URL"
     * }
     */
    public function get(string $mediaId)
    {
        $apiUrl = $this->token->apiUrl(self::API_GET_MATERIAL);
        $response = Curl::to($apiUrl)->withData(json_encode(['media_id' => $mediaId], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param string $mediaId
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok"
     * }
     */
    public function delete(string $mediaId)
    {
        $apiUrl = $this->token->apiUrl(self::API_DELETE_MATERIAL);
        $response = Curl::to($apiUrl)->withData(json_encode(['media_id' => $mediaId], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "voice_count": 1,
     *   "video_count": 2,
     *   "image_count": 3,
     *   "news_count": 4
     * }
     */
    public function count()
    {
        $apiUrl = $this->token->apiUrl(self::API_COUNT_MATERIAL);
        $response = Curl::to($apiUrl)->get();
        return $response->jsonBodyArray();
    }
}