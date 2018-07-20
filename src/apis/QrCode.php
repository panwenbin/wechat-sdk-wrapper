<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\apis;


use panwenbin\helper\Curl;

/**
 * 二维码
 * @package panwenbin\wechat\apis
 */
class QrCode extends TokenBasedApi
{
    const API_CREATE = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={ACCESS_TOKEN}';
    const API_SHOW = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={TICKET}';

    /**
     * 创建二维码
     * @param string $actionName
     * @param $scene
     * @param null $expireSeconds 过期时间(秒)，最大2592000，空为永久
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "ticket": "gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==",
     *   "expire_seconds": 60,
     *   "url": "http://weixin.qq.com/q/kZgfwMTm72WWPkovabbI"
     * }
     */
    public function create(string $actionName, $scene, $expireSeconds = null)
    {
        $apiUrl = $this->token->apiUrl(self::API_CREATE);
        if (is_int($scene)) {
            $actionInfo = ['scene' => ['scene_id' => $scene]];
        } else {
            $actionInfo = ['scene' => ['scene_str' => $scene]];
        }
        $data = [
            'action_name' => $actionName,
            'action_info' => $actionInfo,
        ];
        if ($expireSeconds) {
            $data['expire_seconds'] = $expireSeconds;
        }
        $response = Curl::to($apiUrl)->withData(json_encode($data))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param string $ticket
     * @return string
     * @throws \panwenbin\wechat\exceptions\WechatException
     */
    public function showUrl(string $ticket)
    {
        $showUrl = $this->token->apiUrl(self::API_SHOW, ['{TICKET}' => $ticket]);
        return $showUrl;
    }
}