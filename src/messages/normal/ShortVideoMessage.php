<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\normal;


class ShortVideoMessage extends BaseNormalMessage
{
    public $msgType = 'shortvideo';
    public $mediaId;
    public $thumbMediaId;
}