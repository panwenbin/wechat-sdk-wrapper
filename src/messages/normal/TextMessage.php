<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\normal;


class TextMessage extends BaseNormalMessage
{
    public $msgType = 'text';
    public $content;
}