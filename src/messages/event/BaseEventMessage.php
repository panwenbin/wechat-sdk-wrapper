<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\event;


use panwenbin\wechat\messages\BaseMessage;

class BaseEventMessage extends BaseMessage
{
    public $msgType = 'event';
    public $event;
}