<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

namespace panwenbin\wechat\messages\normal;


class VideoMessage extends BaseNormalMessage
{
    public $msgType = 'video';
    public $mediaId;
    public $thumbMediaId;
}