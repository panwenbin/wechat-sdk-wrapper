<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\normal;


class LinkMessage extends BaseNormalMessage
{
    public $msgType = 'link';
    public $title;
    public $description;
    public $url;
}