<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\apis;


use panwenbin\helper\Curl;
use panwenbin\wechat\messages\mass\BaseMassMessage;

class MassMessage extends TokenBasedApi
{
    const API_SEND_ALL = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token={ACCESS_TOKEN}';
    const API_SEND = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token={ACCESS_TOKEN}';

    /**
     * @param BaseMassMessage $message
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "send job submission success",
     *   "msg_id": 34182,
     *   "msg_data_id": 206227730
     * }
     */
    public function send(BaseMassMessage $message)
    {
        if (is_array($message->to)) {
            $apiUrl = $this->token->apiUrl(self::API_SEND);
        } else {
            $apiUrl = $this->token->apiUrl(self::API_SEND_ALL);
        }
        $json = $message->toJson();
        $response = Curl::to($apiUrl)->withData($json)->post();
        return $response->jsonBodyArray();
    }
}