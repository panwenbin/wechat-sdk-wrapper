<?php
/**
 * @author Pan Wenbin<panwenbin@gmail.com>
 * @copyright winndoo.com
 */

namespace panwenbin\wechat\apis;


use panwenbin\helper\Curl;
use panwenbin\wechat\exceptions\WechatException;

/**
 * 模板消息
 * @package panwenbin\wechat\apis
 */
class Template extends TokenBasedApi
{
    const API_SET_INDUSTRY = 'https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token={ACCESS_TOKEN}';
    const API_GET_INDUSTRY = 'https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token={ACCESS_TOKEN}';
    const API_ALL = 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token={ACCESS_TOKEN}';
    const API_ADD = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token={ACCESS_TOKEN}';
    const API_DEL = 'https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token={ACCESS_TOKEN}';
    const API_SEND = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={ACCESS_TOKEN}';

    /**
     * 设置所属行业
     * 设置行业可在微信公众平台后台完成，每月可修改行业1次，帐号仅可使用所属行业中相关的模板，为方便第三方开发者，提供通过接口调用的方式来修改账号所属行业
     * @param $industryId1
     * @param $industryId2
     * @return array|null
     * @throws WechatException
     *
     * POST数据示例
     * {
     *   "industry_id1": "1",
     *   "industry_id2": "4"
     * }
     */
    public function setIndustry($industryId1, $industryId2)
    {
        $apiUrl = $this->token->apiUrl(self::API_SET_INDUSTRY);
        $response = Curl::to($apiUrl)->withData(json_encode(['industry_id1' => $industryId1, 'industry_id2' => $industryId2], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * 获取设置的行业信息
     * 获取帐号设置的行业信息。可登录微信公众平台，在公众号后台中查看行业信息。为方便第三方开发者，提供通过接口调用的方式来获取帐号所设置的行业信息
     * @return array|null
     * @throws WechatException
     *
     * 正常返回
     * {
     *   "primary_industry": {
     *     "first_class": "运输与仓储",
     *     "second_class": "快递"
     *   },
     *   "secondary_industry": {
     *     "first_class": "IT科技",
     *     "second_class": "互联网|电子商务"
     *   }
     * }
     */
    public function getIndustry()
    {
        $apiUrl = $this->token->apiUrl(self::API_GET_INDUSTRY);
        $response = Curl::to($apiUrl)->get();
        return $response->jsonBodyArray();
    }

    /**
     * 获取模板列表
     * 获取已添加至帐号下所有模板列表，可在微信公众平台后台中查看模板列表信息。为方便第三方开发者，提供通过接口调用的方式来获取帐号下所有模板信息
     * @return array|null
     * @throws WechatException
     *
     * 正常返回
     * {
     *   "template_list": [
     *     {
     *       "template_id": "iPk5sOIt5X_flOVKn5GrTFpncEYTojx6ddbt8WYoV5s",
     *       "title": "领取奖金提醒",
     *       "primary_industry": "IT科技",
     *       "deputy_industry": "互联网|电子商务",
     *       "content": "{ {result.DATA} }\n\n领奖金额:{ {withdrawMoney.DATA} }\n领奖  时间:    { {withdrawTime.DATA} }\n银行信息:{ {cardInfo.DATA} }\n到账时间:  { {arrivedTime.DATA} }\n{ {remark.DATA} }",
     *       "example": "您已提交领奖申请\n\n领奖金额：xxxx元\n领奖时间：2013-10-10 12:22:22\n银行信息：xx银行(尾号xxxx)\n到账时间：预计xxxxxxx\n\n预计将于xxxx到达您的银行卡"
     *     }
     *   ]
     * }
     */
    public function all()
    {
        $apiUrl = $this->token->apiUrl(self::API_ALL);
        $response = Curl::to($apiUrl)->get();
        return $response->jsonBodyArray();
    }

    /**
     * 获得模板ID
     * 从行业模板库选择模板到帐号后台，获得模板ID的过程可在微信公众平台后台完成。为方便第三方开发者，提供通过接口调用的方式来获取模板ID
     * @param $shortId
     * @return array|null
     * @throws WechatException
     *
     * POST数据示例
     * {
     *   "template_id_short": "TM00015"
     * }
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok",
     *   "template_id": "Doclyl5uP7Aciu-qZ7mJNPtWkbkYnWBWVja26EGbNyk"
     * }
     */
    public function add($shortId)
    {
        $apiUrl = $this->token->apiUrl(self::API_ADD);
        $response = Curl::to($apiUrl)->withData(json_encode(['template_id_short' => $shortId], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * 删除模板
     * 删除模板可在微信公众平台后台完成，为方便第三方开发者，提供通过接口调用的方式来删除某帐号下的模板
     * @param $templateId
     * @return array|null
     * @throws WechatException
     *
     * {
     *   "template_id": "Dyvp3-Ff0cnail_CDSzk1fIc6-9lOkxsQE7exTJbwUE"
     * }
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok"
     * }
     */
    public function del($templateId)
    {
        $apiUrl = $this->token->apiUrl(self::API_DEL);
        $response = Curl::to($apiUrl)->withData(json_encode(['template_id' => $templateId], JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }

    /**
     * 发送模板消息
     * @param $openId
     * @param $templateId
     * @param $data
     * @param null $url
     * @param null $miniProgram
     * @return array|null
     * @throws WechatException
     *
     * POST数据示例
     * {
     *   "touser": "OPENID",
     *   "template_id": "ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY",
     *   "url": "http://weixin.qq.com/download",
     *   "miniprogram": {
     *     "appid": "xiaochengxuappid12345",
     *     "pagepath": "index?foo=bar"
     *   },
     *   "data": {
     *     "first": {
     *       "value": "恭喜你购买成功！",
     *       "color": "#173177"
     *     },
     *     "keyword1": {
     *       "value": "巧克力",
     *       "color": "#173177"
     *     },
     *     "keyword2": {
     *       "value": "39.8元",
     *       "color": "#173177"
     *     },
     *     "keyword3": {
     *       "value": "2014年9月22日",
     *       "color": "#173177"
     *     },
     *     "remark": {
     *       "value": "欢迎再次购买！",
     *       "color": "#173177"
     *     }
     *   }
     * }
     *
     * 正常返回
     * {
     *   "errcode": 0,
     *   "errmsg": "ok",
     *   "msgid": 200228332
     * }
     */
    public function send($openId, $templateId, $data, $url = null, $miniProgram = null)
    {
        $postParams = [
            'touser' => $openId,
            'template_id' => $templateId,
            'data' => $data,
        ];
        if ($url) {
            $postParams['url'] = $url;
        }
        if ($miniProgram) {
            $postParams['miniprogram'] = $miniProgram;
        }
        $apiUrl = $this->token->apiUrl(self::API_SEND);
        $response = Curl::to($apiUrl)->withData(json_encode($postParams, JSON_UNESCAPED_UNICODE))->post();
        return $response->jsonBodyArray();
    }
}