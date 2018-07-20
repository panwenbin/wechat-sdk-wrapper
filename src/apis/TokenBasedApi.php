<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\apis;


class TokenBasedApi
{
    /* @var Token */
    protected $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }
}