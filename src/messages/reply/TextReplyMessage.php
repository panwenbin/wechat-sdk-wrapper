<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\reply;


class TextReplyMessage extends BaseReplyMessage
{
    public $msgType = 'text';
    public $content;
}