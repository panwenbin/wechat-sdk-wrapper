<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\apis;


use panwenbin\helper\Curl;

/**
 * 用户标签接口
 * @package panwenbin\wechat\apis
 */
class Tag extends TokenBasedApi
{
    const API_CREATE = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token={ACCESS_TOKEN}';
    const API_GET = 'https://api.weixin.qq.com/cgi-bin/tags/get?access_token={ACCESS_TOKEN}';
    const API_UPDATE = 'https://api.weixin.qq.com/cgi-bin/tags/update?access_token={ACCESS_TOKEN}';
    const API_DELETE = 'https://api.weixin.qq.com/cgi-bin/tags/delete?access_token={ACCESS_TOKEN}';
    const API_GET_USERS = 'https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token={ACCESS_TOKEN}';
    const API_BATCH_TAGGING = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token={ACCESS_TOKEN}';
    const API_BATCH_UN_TAGGING = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token={ACCESS_TOKEN}';
    const API_GET_ID_LIST_ON_USER = 'https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token={ACCESS_TOKEN}';
    const API_GET_BLACK_LIST = 'https://api.weixin.qq.com/cgi-bin/tags/members/getblacklist?access_token={ACCESS_TOKEN}';
    const API_BATCH_BLACK_LIST = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchblacklist?access_token={ACCESS_TOKEN}';
    const API_BATCH_UN_BLACK_LIST = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchunblacklist?access_token={ACCESS_TOKEN}';

    /**
     * @param string $name
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "tag": {
     *     "id": 134,
     *     "name": "广东"
     *   }
     * }
     */
    public function create(string $name)
    {
        $apiUrl = $this->token->apiUrl(self::API_CREATE);
        $response = Curl::to($apiUrl)->withData(json_encode(['tag' => ['name' => $name]], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "tags": [
     *     {
     *       "id": 1,
     *       "name": "每天一罐可乐星人",
     *       "count": 0
     *     },
     *     {
     *       "id": 2,
     *       "name": "星标组",
     *       "count": 0
     *     },
     *     {
     *       "id": 127,
     *       "name": "广东",
     *       "count": 5
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
     * @param $id
     * @param $name
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok"
     * }
     */
    public function update(int $id, string $name)
    {
        $apiUrl = $this->token->apiUrl(self::API_UPDATE);
        $response = Curl::to($apiUrl)->withData(json_encode(['tag' => ['id' => $id, 'name' => $name]], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param int $id
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok"
     * }
     */
    public function delete(int $id)
    {
        $apiUrl = $this->token->apiUrl(self::API_DELETE);
        $response = Curl::to($apiUrl)->withData(json_encode(['tag' => ['id' => $id]], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param int $tagId
     * @param string $nextOpenid 第一个拉取的OPENID，不填默认从头开始拉取
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "count": 2,
     *   "data": {
     *     "openid": [
     *       "ocYxcuAEy30bX0NXmGn4ypqx3tI0",
     *       "ocYxcuBt0mRugKZ7tGAHPnUaOW7Y"
     *     ]
     *   },
     *   "next_openid": "ocYxcuBt0mRugKZ7tGAHPnUaOW7Y"
     * }
     */
    public function getUsers(int $tagId, string $nextOpenid = '')
    {
        $apiUrl = $this->token->apiUrl(self::API_GET_USERS);
        $response = Curl::to($apiUrl)->withData(json_encode(['tagid' => $tagId, 'next_openid' => $nextOpenid], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param array $openidList
     * @param int $tagId
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok"
     * }
     */
    public function batchTagging(array $openidList, int $tagId)
    {
        $apiUrl = $this->token->apiUrl(self::API_BATCH_TAGGING);
        $response = Curl::to($apiUrl)->withData(json_encode(['openid_list' => $openidList, 'tagid' => $tagId], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param array $openidList
     * @param int $tagId
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok"
     * }
     */
    public function batchUnTagging(array $openidList, int $tagId)
    {
        $apiUrl = $this->token->apiUrl(self::API_BATCH_UN_TAGGING);
        $response = Curl::to($apiUrl)->withData(json_encode(['openid_list' => $openidList, 'tagid' => $tagId], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param string $openid
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "tagid_list": [
     *     134,
     *     2
     *   ]
     * }
     */
    public function getIdListOnUser(string $openid)
    {
        $apiUrl = $this->token->apiUrl(self::API_GET_ID_LIST_ON_USER);
        $response = Curl::to($apiUrl)->withData(json_encode(['openid' => $openid], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param string $beginOpenid
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "total": 23000,
     *   "count": 10000,
     *   "data": {
     *     "openid": [
     *       "OPENID1",
     *       "OPENID2",
     *       "OPENID10000"
     *     ]
     *   },
     *   "next_openid": "OPENID10000"
     * }
     */
    public function getBlackList(string $beginOpenid = '')
    {
        $apiUrl = $this->token->apiUrl(self::API_GET_BLACK_LIST);
        $response = Curl::to($apiUrl)->withData(json_encode(['begin_openid' => $beginOpenid], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param array $openidList
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok"
     * }
     */
    public function batchBlackList(array $openidList)
    {
        $apiUrl = $this->token->apiUrl(self::API_BATCH_BLACK_LIST);
        $response = Curl::to($apiUrl)->withData(json_encode(['openid_list' => $openidList], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * @param array $openidList
     * @return array|null
     * @throws \panwenbin\wechat\exceptions\WechatException
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok"
     * }
     */
    public function batchUnBlackList(array $openidList)
    {
        $apiUrl = $this->token->apiUrl(self::API_BATCH_UN_BLACK_LIST);
        $response = Curl::to($apiUrl)->withData(json_encode(['openid_list' => $openidList], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }
}