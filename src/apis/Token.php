<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\apis;


use panwenbin\wechat\Config;
use panwenbin\wechat\exceptions\WechatException;

/**
 * Access Token 获取与持久化
 * @package panwenbin\wechat\apis
 */
class Token
{
    const API_TOKEN = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={APPID}&secret={APPSECRET}';

    /* @var \panwenbin\wechat\Config */
    protected $config;

    protected $accessToken;

    protected $expiresAt;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     * @throws WechatException
     */
    public function fetch()
    {
        if (isset($this->accessToken) && $this->isAvailable()) {
            return $this->accessToken;
        }
        $this->read();
        if (empty($this->accessToken) || $this->isAvailable() == false) {
            $this->grant();
            $this->write();
        }
        return $this->accessToken;
    }

    /**
     * @throws WechatException
     */
    public function grant()
    {
        $apiUrl = $this->config->apiUrl(self::API_TOKEN);
        $json = file_get_contents($apiUrl);
        $jsonArr = json_decode($json, true);
        if (isset($jsonArr['errcode'], $jsonArr['errmsg'])) {
            throw new WechatException($jsonArr['errmsg'], $jsonArr['errcode']);
        }
        $this->accessToken = $jsonArr['access_token'] ?? null;
        $this->expiresAt = ($jsonArr['expires_in'] ?? 7200) + time();
    }

    protected function isAvailable()
    {
        return time() < $this->expiresAt;
    }

    /**
     * 重写此方法持久化$this->accessToken和$this->expiresAt
     * @return bool
     */
    protected function write()
    {
        $tokenFile = sys_get_temp_dir() . '/wx_access_token_for_' . $this->config->getAppid();
        file_put_contents($tokenFile, json_encode(['accessToken' => $this->accessToken, 'expiresAt' => $this->expiresAt]));
        return true;
    }

    /**
     * 重写此方法读取持久化的accessToken到$this->accessToken和$this->expiresAt
     */
    protected function read()
    {
        $tokenFile = sys_get_temp_dir() . '/wx_access_token_for_' . $this->config->getAppid();
        if (file_exists($tokenFile)) {
            $tokenArr = json_decode(file_get_contents($tokenFile), true);
            if (isset($tokenArr['accessToken'], $tokenArr['expiresAt'])) {
                $this->accessToken = $tokenArr['accessToken'];
                $this->expiresAt = $tokenArr['expiresAt'];
            }
        }
    }

    /**
     * 给其他接口使用，用于替换Token值
     * @param string $url
     * @param array $replaces
     * @return string
     * @throws WechatException
     */
    public function apiUrl(string $url, array $replaces = [])
    {
        $this->fetch();
        $replaces['{ACCESS_TOKEN}'] = $this->accessToken;
        return strtr($url, $replaces);
    }
}