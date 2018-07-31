<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages;


use panwenbin\wechat\exceptions\MsgTypeNotMatchException;
use panwenbin\wechat\exceptions\WechatException;
use panwenbin\wechat\messages\reply\BaseReplyMessage;

class BaseMessage
{
    public $toUserName;
    public $fromUserName;
    public $createTime;
    public $msgType;

    /**
     * BaseMessage constructor.
     * @param array $params
     * @throws MsgTypeNotMatchException
     */
    public function __construct(array $params)
    {
        foreach ($params as $key => $value) {
            $key = lcfirst($key);
            if ($key == 'msgType' && strcmp($this->msgType, $value) !== 0) {
                throw new MsgTypeNotMatchException();
            }
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @param callable $callback
     * @return string
     */
    public function autoReply(callable $callback)
    {
        /* @var \panwenbin\wechat\messages\reply\BaseReplyMessage $message */
        $message = call_user_func($callback);
        if ($message instanceof BaseReplyMessage) {
            $message->toUserName = $message->toUserName ?: $this->fromUserName;
            $message->fromUserName = $message->fromUserName ?: $this->toUserName;
            $message->createTime = $message->createTime ?: time();
            return $message->toXml();
        } else {
            return 'success';
        }
    }
}