<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages;


use panwenbin\wechat\exceptions\SignatureInvalidException;

/**
 * 接口绑定时的验证消息，通过GET参数发送
 * @package panwenbin\wechat\messages
 */
class BindRequest
{
    /**
     * @var string 在填写服务器配置中配置的Token
     */
    protected $token;

    protected $echostr;
    protected $nonce;
    protected $timestamp;
    protected $signature;

    /**
     * BindRequest constructor.
     * @param string $token 配置的Token
     * @param array $gets GET参数
     */
    public function __construct(string $token, array $gets)
    {
        $this->token = $token;
        $this->echostr = $gets['echostr'] ?? '';
        $this->nonce = $gets['nonce'] ?? '';
        $this->timestamp = $gets['timestamp'] ?? '';
        $this->signature = $gets['signature'] ?? '';
    }

    /**
     * 验证签名
     * @throws SignatureInvalidException
     */
    protected function validateSignature()
    {
        $params = [$this->nonce, $this->timestamp, $this->token];
        sort($params, SORT_STRING);
        $signature = sha1(implode($params));
        if (strcmp($signature, $this->signature) !== 0) {
            throw new SignatureInvalidException();
        }
    }

    /**
     * 原样响应echostr
     * @return mixed|string
     * @throws SignatureInvalidException
     */
    public function reply()
    {
        $this->validateSignature();
        return $this->echostr;
    }
}