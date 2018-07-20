<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\apis;


use panwenbin\helper\Curl;

/**
 * 用户接口
 * @package panwenbin\wechat\apis
 */
class User extends TokenBasedApi
{
    const API_GET_LIST = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token={ACCESS_TOKEN}&next_openid={NEXT_OPENID}';
    const API_UPDATE_REMARK = 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token={ACCESS_TOKEN}';
    const API_INFO = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token={ACCESS_TOKEN}&openid={OPENID}&lang={LANG}';
    const API_INFO_BATCH_GET = 'https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token={ACCESS_TOKEN}';

    /**
     * @param string $nextOpenid
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     *
     * {
     *   "total": 2,
     *   "count": 2,
     *   "data": {
     *     "openid": [
     *       "OPENID1",
     *       "OPENID2"
     *     ]
     *   },
     *   "next_openid": "NEXT_OPENID"
     * }
     */
    public function getList(string $nextOpenid = '')
    {
        $apiUrl = $this->token->apiUrl(self::API_GET_LIST, ['{NEXT_OPENID}' => $nextOpenid]);
        $response = Curl::to($apiUrl)->get();
        return $response->jsonBodyArray();
    }

    /**
     * @param string $openid
     * @param string $remark
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok"
     * }
     */
    public function updateRemark(string $openid, string $remark)
    {
        $apiUrl = $this->token->apiUrl(self::API_UPDATE_REMARK);
        $response = Curl::to($apiUrl)->withData(json_encode(['openid' => $openid, 'remark' => $remark]))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param string $openid
     * @param string $lang
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "subscribe": 1,
     *   "openid": "o6_bmjrPTlm6_2sgVt7hMZOPfL2M",
     *   "nickname": "Band",
     *   "sex": 1,
     *   "language": "zh_CN",
     *   "city": "广州",
     *   "province": "广东",
     *   "country": "中国",
     *   "headimgurl": "http://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
     *   "subscribe_time": 1382694957,
     *   "unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL",
     *   "remark": "",
     *   "groupid": 0,
     *   "tagid_list": [
     *     128,
     *     2
     *   ],
     *   "subscribe_scene": "ADD_SCENE_QR_CODE",
     *   "qr_scene": 98765,
     *   "qr_scene_str": ""
     * }
     */
    public function info(string $openid, string $lang = 'zh_CN')
    {
        $apiUrl = $this->token->apiUrl(self::API_INFO, ['{OPENID}' => $openid, '{LANG}' => $lang]);
        $response = Curl::to($apiUrl)->get();
        return $response->jsonBodyArray();
    }

    /**
     * @param array $openids
     * @param string $lang
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "user_info_list": [
     *     {
     *       "subscribe": 1,
     *       "openid": "otvxTs4dckWG7imySrJd6jSi0CWE",
     *       "nickname": "iWithery",
     *       "sex": 1,
     *       "language": "zh_CN",
     *       "city": "揭阳",
     *       "province": "广东",
     *       "country": "中国",
     *       "headimgurl": "http://thirdwx.qlogo.cn/mmopen/xbIQx1GRqdvyqkMMhEaGOX802l1CyqMJNgUzKP8MeAeHFicRDSnZH7FY4XB7p8XHXIf6uJA2SCunTPicGKezDC4saKISzRj3nz/0",
     *       "subscribe_time": 1434093047,
     *       "unionid": "oR5GjjgEhCMJFyzaVZdrxZ2zRRF4",
     *       "remark": "",
     *       "groupid": 0,
     *       "tagid_list": [
     *         128,
     *         2
     *       ],
     *       "subscribe_scene": "ADD_SCENE_QR_CODE",
     *       "qr_scene": 98765,
     *       "qr_scene_str": ""
     *     },
     *     {
     *       "subscribe": 0,
     *       "openid": "otvxTs_JZ6SEiP0imdhpi50fuSZg"
     *     }
     *   ]
     * }
     */
    public function infoBatchGet(array $openids, string $lang = 'zh_CN')
    {
        $userList = [];
        foreach ($openids as $openid) {
            $userList[] = ['openid' => $openid, 'lang' => $lang];
        }
        $apiUrl = $this->token->apiUrl(self::API_INFO);
        $response = Curl::to($apiUrl)->withData(json_encode($userList))->post();
        return $response->jsonBodyArray();
    }
}