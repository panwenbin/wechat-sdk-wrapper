<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\apis;
use panwenbin\helper\Curl;


/**
 * 个性化菜单，需要已认证订阅号或已认证服务号
 * @package panwenbin\wechat\apis
 */
class ConditionalMenu extends TokenBasedApi
{
    const API_ADD = 'https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token={ACCESS_TOKEN}';
    const API_DELETE = 'https://api.weixin.qq.com/cgi-bin/menu/delconditional?access_token={ACCESS_TOKEN}';
    const API_TRY_MATCH = 'https://api.weixin.qq.com/cgi-bin/menu/trymatch?access_token={ACCESS_TOKEN}';

    /**
     * @param array $buttons
     * @param $matchRule
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 请求示例
     * {
     *   "button": [
     *     {
     *       "type": "click",
     *       "name": "今日歌曲",
     *       "key": "V1001_TODAY_MUSIC"
     *     },
     *     {
     *       "name": "菜单",
     *       "sub_button": [
     *         {
     *           "type": "view",
     *           "name": "搜索",
     *           "url": "http://www.soso.com/"
     *         },
     *         {
     *           "type": "miniprogram",
     *           "name": "wxa",
     *           "url": "http://mp.weixin.qq.com",
     *           "appid": "wx286b93c14bbf93aa",
     *           "pagepath": "pages/lunar/index"
     *         },
     *         {
     *           "type": "click",
     *           "name": "赞一下我们",
     *           "key": "V1001_GOOD"
     *         }
     *       ]
     *     }
     *   ],
     *   "matchrule": {
     *     "tag_id": "2",
     *     "sex": "1",
     *     "country": "中国",
     *     "province": "广东",
     *     "city": "广州",
     *     "client_platform_type": "2",
     *     "language": "zh_CN"
     *   }
     * }
     *
     * 正常返回
     * {
     *   "menuid": "208379533"
     * }
     *
     */
    public function add(array $buttons, $matchRule)
    {
        $apiUrl = $this->token->apiUrl(self::API_ADD);
        $response = Curl::to($apiUrl)->withData(json_encode(['button' => $buttons, 'matchrule' => $matchRule], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param string $menuId
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok"
     * }
     */
    public function delete(string $menuId)
    {
        $apiUrl = $this->token->apiUrl(self::API_DELETE);
        $response = Curl::to($apiUrl)->withData(json_encode(['menuid' => $menuId], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param string $userId OpenID或者微信号
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "button": [
     *     {
     *       "type": "view",
     *       "name": "tx",
     *       "url": "http://www.qq.com/",
     *       "sub_button": []
     *     },
     *     {
     *       "type": "view",
     *       "name": "tx",
     *       "url": "http://www.qq.com/",
     *       "sub_button": []
     *     },
     *     {
     *       "type": "view",
     *       "name": "tx",
     *       "url": "http://www.qq.com/",
     *       "sub_button": []
     *     }
     *   ]
     * }
     */
    public function tryMatch(string $userId)
    {
        $apiUrl = $this->token->apiUrl(self::API_TRY_MATCH);
        $response = Curl::to($apiUrl)->withData(json_encode(['user_id' => $userId], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }
}