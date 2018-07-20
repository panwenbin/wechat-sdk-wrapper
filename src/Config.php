<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat;


/**
 * 配置
 * @package panwenbin\wechat
 */
class Config
{
    protected $appid;
    protected $secret;

    public function __construct(string $appid, string $secret)
    {
        $this->appid = $appid;
        $this->secret = $secret;
    }

    public function getAppid()
    {
        return $this->appid;
    }

    /**
     * 给Token接口使用，用于替换AppId和AppSecret
     * @param string $url
     * @param array $replaces
     * @return string
     */
    public function apiUrl(string $url, array $replaces = [])
    {
        $replaces['{APPID}'] = $this->appid;
        $replaces['{APPSECRET}'] = $this->secret;
        return strtr($url, $replaces);
    }
}