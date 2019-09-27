<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\apis;


use panwenbin\helper\Curl;

/**
 * 缩短网址
 * @package panwenbin\wechat\apis
 */
class ShortUrl extends TokenBasedApi
{
    const API_SHORTEN = 'https://api.weixin.qq.com/cgi-bin/shorturl?access_token={ACCESS_TOKEN}';

    /**
     * @param string $longUrl
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok",
     *   "short_url": "http:\/\/w.url.cn\/s\/AvCo6Ih"
     * }
     */
    public function shorten(string $longUrl)
    {
        $apiUrl = $this->token->apiUrl(self::API_SHORTEN);
        $response = Curl::to($apiUrl)->withData(json_encode(['action' => 'long2short', 'long_url' => $longUrl], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }
}