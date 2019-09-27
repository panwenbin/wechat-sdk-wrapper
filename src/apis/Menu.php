<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\apis;


use panwenbin\helper\Curl;

/**
 * 自定义菜单
 * @package panwenbin\wechat\apis
 */
class Menu extends TokenBasedApi
{
    const API_CREATE = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token={ACCESS_TOKEN}';
    const API_GET = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token={ACCESS_TOKEN}';
    const API_DELETE = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={ACCESS_TOKEN}';

    /**
     * @param array $buttons
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 传入格式
     * [
     *   {
     *     "type": "click",
     *     "name": "今日歌曲",
     *     "key": "V1001_TODAY_MUSIC"
     *   },
     *   {
     *     "name": "菜单",
     *     "sub_button": [
     *       {
     *         "type": "view",
     *         "name": "搜索",
     *         "url": "http://www.soso.com/"
     *       },
     *       {
     *         "type": "miniprogram",
     *         "name": "wxa",
     *         "url": "http://mp.weixin.qq.com",
     *         "appid": "wx286b93c14bbf93aa",
     *         "pagepath": "pages/lunar/index"
     *       },
     *       {
     *         "type": "click",
     *         "name": "赞一下我们",
     *         "key": "V1001_GOOD"
     *       }
     *     ]
     *   }
     * ]
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok"
     * }
     */
    public function create(array $buttons)
    {
        $apiUrl = $this->token->apiUrl(self::API_CREATE);
        $response = Curl::to($apiUrl)->withData(json_encode(['button' => $buttons], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回，无个性化菜单时
     * {
     *   "menu": {
     *     "button": [
     *       {
     *         "type": "click",
     *         "name": "今日歌曲",
     *         "key": "V1001_TODAY_MUSIC",
     *         "sub_button": []
     *       },
     *       {
     *         "type": "click",
     *         "name": "歌手简介",
     *         "key": "V1001_TODAY_SINGER",
     *         "sub_button": []
     *       },
     *       {
     *         "name": "菜单",
     *         "sub_button": [
     *           {
     *             "type": "view",
     *             "name": "搜索",
     *             "url": "http://www.soso.com/",
     *             "sub_button": []
     *           },
     *           {
     *             "type": "view",
     *             "name": "视频",
     *             "url": "http://v.qq.com/",
     *             "sub_button": []
     *           },
     *           {
     *             "type": "click",
     *             "name": "赞一下我们",
     *             "key": "V1001_GOOD",
     *             "sub_button": []
     *           }
     *         ]
     *       }
     *     ]
     *   }
     * }
     *
     * 有个性化菜单时
     * {
     *   "menu": {
     *     "button": [
     *       {
     *         "type": "click",
     *         "name": "今日歌曲",
     *         "key": "V1001_TODAY_MUSIC",
     *         "sub_button": []
     *       }
     *     ],
     *     "menuid": 208396938
     *   },
     *   "conditionalmenu": [
     *     {
     *       "button": [
     *         {
     *           "type": "click",
     *           "name": "今日歌曲",
     *           "key": "V1001_TODAY_MUSIC",
     *           "sub_button": []
     *         },
     *         {
     *           "name": "菜单",
     *           "sub_button": [
     *             {
     *               "type": "view",
     *               "name": "搜索",
     *               "url": "http://www.soso.com/",
     *               "sub_button": []
     *             },
     *             {
     *               "type": "view",
     *               "name": "视频",
     *               "url": "http://v.qq.com/",
     *               "sub_button": []
     *             },
     *             {
     *               "type": "click",
     *               "name": "赞一下我们",
     *               "key": "V1001_GOOD",
     *               "sub_button": []
     *             }
     *           ]
     *         }
     *       ],
     *       "matchrule": {
     *         "group_id": 2,
     *         "sex": 1,
     *         "country": "中国",
     *         "province": "广东",
     *         "city": "广州",
     *         "client_platform_type": 2
     *       },
     *       "menuid": 208396993
     *     }
     *   ]
     * }
     */
    public function get()
    {
        $apiUrl = $this->token->apiUrl(self::API_GET);
        $response = Curl::to($apiUrl)->get();
        return $response->jsonBodyArray();
    }

    /**
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok"
     * }
     */
    public function delete()
    {
        $apiUrl = $this->token->apiUrl(self::API_DELETE);
        $response = Curl::to($apiUrl)->get();
        return $response->jsonBodyArray();
    }
}