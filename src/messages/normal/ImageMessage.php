<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\normal;


class ImageMessage extends BaseNormalMessage
{
    public $msgType = 'image';
    public $picUrl;
    public $mediaId;
}